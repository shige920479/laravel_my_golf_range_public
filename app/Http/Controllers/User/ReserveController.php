<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveRequest;
use App\Mail\TestMail;
use App\Models\DrivingRange;
use App\Models\RangeFee;
use App\Models\Rental;
use App\Models\ReserveRange;
use App\Models\ReserveRental;
use App\Models\ReserveShower;
use App\Models\Shower;
use App\Services\CheckReservationService;
use App\Services\ReservationService;
use App\Services\WeatherService;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Log;
use PDOException;

class ReserveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }

    public function create(Request $request)
    {
        $ranges = DrivingRange::select('id', 'name')->get();
        $searchDate = $request->search_date ?? Carbon::today()->format('Y-m-d');
        $refDate = Carbon::today();
        $rentals = Rental::select('id', 'brand', 'model')->get();
        $openTime = Carbon::createFromTime(\Constant::OPEN_TIME, 0);
        $closeTime = Carbon::createFromTime(\Constant::CLOSE_TIME, 0);
        $allData = ReservationService::getDailyReserveData($searchDate);
        $weatherInfo = WeatherService::getWeatherForDate($searchDate);

        return view('user.reserve', compact(
            'ranges', 'refDate', 'rentals', 'openTime', 'closeTime', 'searchDate','allData', 'weatherInfo'));
    }

    public function store(ReserveRequest $request)
    {   
        $checkAvalibaleTime = CheckReservationService::validateReservationTime($request->reserve_date, $request->start_time);
        if($checkAvalibaleTime !== true) return $checkAvalibaleTime;
        $checkDoubleBook = CheckReservationService::checkDoubleBook($request->all());
        if($checkDoubleBook !== true) return $checkDoubleBook;
        $checkMainteAndReserved = CheckReservationService::checkMainteAndReserved($request->all());
        if($checkMainteAndReserved !== true) return $checkMainteAndReserved;
        
        $validatedReserve = $request->validated();
        list($entranceFee, $rangeFee, $rentalFee, $showerFee) = ReservationService::calcFee($request);
        $validatedReserve['entrance_fee'] = $entranceFee;
        $validatedReserve['range_fee'] = $rangeFee;
        $validatedReserve['rental_fee'] = $rentalFee;
        $validatedReserve['shower_fee'] = $showerFee;
        $validatedReserve['search_date'] = $request->search_date;
        session(['reservation' => $validatedReserve]);
        
        return to_route('user.reserve.confirm');
    }

    public function confirm()
    {
        $reservation = session('reservation', []);
        $rangeName = DrivingRange::findOrFail($reservation['driving_range_id'])->name;
        $rental = Rental::find($reservation['rental_id']);
        if(! is_null($rental)) $rental = $rental->brand . ' / ' . $rental->model;
        return view('user.confirm', compact('reservation', 'rangeName', 'rental'));
    }

    public function send()
    {
        $input = session('reservation', []);
        $checkBeforeSend = CheckReservationService::checkMainteAndReserved($input);
        if($checkBeforeSend !== true) return $checkBeforeSend; 

        try {
            DB::beginTransaction();
            $reserveRange = ReserveRange::create([
                'user_id' => Auth::id(),
                'driving_range_id' => session('reservation.driving_range_id'),
                'reserve_date' => session('reservation.reserve_date'),
                'start_time' => session('reservation.start_time'),
                'end_time' => session('reservation.end_time'),
                'number' => session('reservation.number'),
                'fee' => session('reservation.entrance_fee') + session('reservation.range_fee')
            ]);
            if(! is_null(session('reservation.rental_id'))) {
                ReserveRental::create([
                'user_id' => Auth::id(),
                'rental_id' => session('reservation.rental_id'),
                'reserve_range_id' => $reserveRange->id,
                'reserve_date' => session('reservation.reserve_date'),
                'start_time' => session('reservation.start_time'),
                'end_time' => session('reservation.end_time'),
                'fee' => session('reservation.rental_fee')
                ]);
            }
            if(! is_null(session('reservation.shower_time'))) {
                ReserveShower::create([
                'user_id' => Auth::id(),
                'reserve_range_id' => $reserveRange->id,
                'reserve_date' => session('reservation.reserve_date'),
                'shower_time' => session('reservation.shower_time'),
                'fee' => session('reservation.shower_fee')
                ]);
            }
            DB::commit();
            session()->forget('reservation');

            return to_route('user.reserve.complete');

        } catch (PDOException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(500);
        }
    }
    
    public function complete()
    {
        return view('user.complete');
    }
}
