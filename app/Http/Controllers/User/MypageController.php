<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveRequest;
use App\Models\DrivingRange;
use App\Models\Rental;
use App\Models\ReserveRange;
use App\Models\ReserveRental;
use App\Models\ReserveShower;
use App\Services\CheckReservationService;
use App\Services\ReservationService;
use App\Services\WeatherService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;
use PDOException;


class MypageController extends Controller
{
    public function __construct()
    {
        // ルートパラメーターの持主がログインユーザーと違っていればNG
        $this->middleware('auth:users');

        $this->middleware(function($request, $next) {
            $reserveId = $request->route()->parameter('id');
            if(! is_null($reserveId)) {
                $reserveUserId = ReserveRange::findOrFail($reserveId)->user_id;
                if(Auth::id() !== $reserveUserId) {
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        $reserved = ReserveRange::where('user_id', Auth::id())
        ->where(function($query) {
            $query->where('reserve_date', Carbon::today())
            ->where('end_time', '>', Carbon::now()->format('H:i:s'))
            ->orWhere('reserve_date', '>', Carbon::today());
        })
        ->with(['drivingRange','reserveRental.rental','reserveShower'])
        ->orderBy('reserve_date', 'asc')
        ->orderBy('start_time', 'asc')
        ->get();

        return view('user.mypage', compact('reserved'));
    }

    public function edit(Request $request, int $id)
    {
        $reserved = ReserveRange::where('id', $id)
        ->with(['reserveRental','reserveShower'])->first();

        $ranges = DrivingRange::select('id', 'name')->get();
        $searchDate = $request->search_date ?? Carbon::today()->format('Y-m-d');
        $refDate = Carbon::today();
        $rentals = Rental::select('id', 'brand', 'model')->get();
        $openTime = Carbon::createFromTime(\Constant::OPEN_TIME, 0);
        $closeTime = Carbon::createFromTime(\Constant::CLOSE_TIME, 0);
        $allData = ReservationService::getDailyReserveData($searchDate);
        $weatherInfo = WeatherService::getWeatherForDate($searchDate);

        return view('user.edit', compact(
            'reserved' ,'id' ,'ranges', 'refDate', 'rentals', 'openTime', 'closeTime', 'searchDate','allData', 'weatherInfo'));
    }

    public function store(ReserveRequest $request, int $id)
    {
        // バリデーション、予約可否チェック
        $checkAvalibaleTime = CheckReservationService::validateReservationTime($request->reserve_date, $request->start_time);
        if($checkAvalibaleTime !== true) return $checkAvalibaleTime;
        $checkDoubleBook = CheckReservationService::checkDoubleBook($request->all(), $id);
        if($checkDoubleBook !== true) return $checkDoubleBook;
        $checkMainteAndReserved = CheckReservationService::checkMainteAndReserved($request->all(), $id);
        if($checkMainteAndReserved !== true) return $checkMainteAndReserved;
        $validatedReserve = $request->validated();

        // 料金計算
        list($entranceFee, $rangeFee, $rentalFee, $showerFee) = ReservationService::calcFee($request);
        $validatedReserve['entrance_fee'] = $entranceFee;
        $validatedReserve['range_fee'] = $rangeFee;
        $validatedReserve['rental_fee'] = $rentalFee;
        $validatedReserve['shower_fee'] = $showerFee;
        $validatedReserve['search_date'] = $request->search_date;

        $valueRental = $request->rental ?? 0;
        $valueShower = $request->shower ?? 0;
        $validatedReserve['rental'] = $valueRental;
        $validatedReserve['shower'] = $valueShower;

        session(['reservation' => $validatedReserve]);

        return to_route('user.mypage.confirm', ['id' => $id]);
    }

    public function confirm(int $id)
    {
        $reservation = session('reservation', []);
        $rangeName = DrivingRange::findOrFail($reservation['driving_range_id'])->name;
        $rental = Rental::find($reservation['rental_id']);
        if(! is_null($rental)) $rental = $rental->brand . ' / ' . $rental->model;

        return view('user.editConfirm', compact('id', 'reservation', 'rangeName', 'rental'));
    }

    public function send(int $id)
    {
        $input = session('reservation', []);
        $checkBeforeSend = CheckReservationService::checkMainteAndReserved($input, $id);
        if($checkBeforeSend !== true) return $checkBeforeSend; 

        try {
            DB::beginTransaction();

            $reservedRange = ReserveRange::findOrFail($id);
            $storeData = collect($input)->only(['driving_range_id', 'number', 'reserve_date', 'start_time', 'end_time'])->all();
            $storeData['fee'] = $input['entrance_fee'] + $input['range_fee'];
            $reservedRange->update($storeData);


            if($reservedRental = ReserveRental::where('reserve_range_id', $id)->first())
            {
                if($input['rental']) {
                    $storeData = collect($input)->only(['rental_id', 'reserve_date' ,'start_time', 'end_time'])->all();
                    $storeData['fee'] = $input['rental_fee'];
                    $reservedRental->update($storeData);
                } else {
                    $reservedRental->delete();
                }
            } else {
                if($input['rental']) {
                    $storeData = collect($input)->only(['rental_id', 'reserve_date', 'start_time', 'end_time'])->all();
                    $storeData['user_id'] = Auth::id();
                    $storeData['reserve_range_id'] = $id;
                    $storeData['fee'] = $input['rental_fee'];
                    ReserveRental::create($storeData);
                }
            }

            if($reservedShower = ReserveShower::where('reserve_range_id', $id)->first())
            {
                if($input['shower']) {
                    $storeData = collect($input)->only(['reserve_date', 'shower_time', 'shower_fee'])->all();
                    $storeData['fee'] = $input['shower_fee'];
                    $reservedShower->update($storeData);
                } else {
                    $reservedShower->delete();
                }
            } else {
                if($input['shower']) {
                    $storeData = collect($input)->only(['reserve_date', 'shower_time', 'shower_fee'])->all();
                    $storeData['user_id'] = Auth::id();
                    $storeData['reserve_range_id'] = $id;
                    $storeData['fee'] = $input['shower_fee'];
                    ReserveShower::create($storeData);
                }
            }

            DB::commit();
            session()->forget('reservation');
            return to_route('user.mypage.complete', ['id' => $id]);

        } catch(PDOException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function complete(int $id)
    {
        return view('user.editComplete');
    }

    public function cancelConfirm(int $id)
    {
        $reserved = ReserveRange::where('id', $id)->with(['reserveRental', 'reserveShower', 'drivingRange'])->first();
        return view('user.cancelConfirm', compact('reserved'));
    }

    public function cancelExec($id)
    {
        $reserved = ReserveRange::find($id);
        if(is_null($reserved)) {
            return to_route('user.mypage.index')->withErrors(['cancelled' =>'予約情報がありません']);
        }

        try{
            DB::transaction(function () use ($reserved) {
                $reserved->delete();
            });
            return to_route('user.mypage.cancel.complete');
        
        } catch(PDOException $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function cancelComplete()
    {
        return view('user.editComplete');
    }

}
