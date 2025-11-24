<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainteRequest;
use App\Models\DrivingRange;
use App\Models\RangeFee;
use App\Models\Rental;
use App\Models\RentalFee;
use App\Models\Shower;
use App\Models\ShowerFee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');
    }

    public function showSettings()
    {
        $rangeFee = RangeFee::orderby('effective_date', 'desc')->limit(2)->get();
        $rentalFee = rentalFee::orderby('effective_date', 'desc')->limit(2)->get();
        $showerFee = showerFee::orderby('effective_date', 'desc')->limit(2)->get();
        
        if($rangeFee->first()->effective_date <= Carbon::today()) $rangeFee = $rangeFee->take(1);
        if($rentalFee->first()->effective_date <=  Carbon::today()) $rentalFee = $rentalFee->take(1);
        if($showerFee->first()->effective_date <=  Carbon::today()) $showerFee = $showerFee->take(1);
        
        $rentalClubs = Rental::select('brand', 'model', 'mainte_date')->get();
        
        $drivingRanges = DB::table('driving_ranges')
            ->selectRaw("'drivingRange' AS category, id, name, NULL AS brand, NULL AS model, mainte_date");
        $rentals = DB::table('rentals')
            ->selectRaw("'rental' AS category, id, NULL AS name, brand, model, mainte_date");
        $showers = DB::table('showers')
            ->selectRaw("'shower' AS category, id, NULL AS name, NULL AS brand, NULL AS model, mainte_date");
        $maintes = $drivingRanges->union($rentals)->union($showers)->orderBy('category')->get();

        return view('owner.settings', compact('rangeFee', 'rentalFee', 'showerFee', 'rentalClubs', 'maintes'));
    }

    public function rangeFeeForm()
    {
        $rangeFee = RangeFee::orderBy('effective_date', 'desc')->first();
        return view('owner.rangeFee', compact('rangeFee'));
    }

    public function setNewRangeFee(Request $request, string $redirect)
    {
        $request->validate([
            'entrance_fee' => ['required', 'integer'],
            'weekday_fee' => ['required', 'integer'],
            'holiday_fee' => ['required', 'integer'],
            'effective_date' => ['required', 'date', 'after:tomorrow'] // 本来は3週間先以降
        ]);
        $rangeFee = $request->only('entrance_fee', 'weekday_fee', 'holiday_fee', 'effective_date');
        RangeFee::create($rangeFee);

        if($redirect === 'init') return to_route('owner.initForm')->with('success-rangeFee', 'ドライビングレンジ料金を登録しました。');
        if($redirect === 'settings') return to_route('owner.settings')->with('success-rangeFee', 'ドライビングレンジの料金変更を登録しました。');
    }

    public function rentalFeeForm()
    {
        $rentalFee = RentalFee::orderBy('effective_date', 'desc')->first();
        return view('owner.rentalFee', compact('rentalFee'));
    }

    public function setNewRentalFee(Request $request, string $redirect)
    {
        $request->validate([
            'rental_fee' => ['required', 'integer'],
            'effective_date' => ['required', 'date', 'after:tomorrow'] // 本来は3週間先以降
        ]);
        $rentalFee = $request->only('rental_fee', 'effective_date');
        RentalFee::create($rentalFee);

        if($redirect === 'init') return to_route('owner.initForm')->with('success-rentalFee', 'レンタルクラブ料金を登録しました。');
        if($redirect === 'settings') return to_route('owner.settings')->with('success-optionFee', 'レンタルクラブの料金変更を登録しました。');
    }

    public function showerFeeForm()
    {
        $showerFee = ShowerFee::orderBy('effective_date', 'desc')->first();
        return view('owner.showerFee', compact('showerFee'));
    }

    public function setNewShowerFee(Request $request, string $redirect)
    {
        $request->validate([
            'shower_fee' => ['required', 'integer'],
            'effective_date' => ['required', 'after:tomorrow']
        ]);
        $showerFee = $request->only('shower_fee', 'effective_date');
        ShowerFee::create($showerFee);

        if($redirect === 'init') return to_route('owner.initForm')->with('success-showerFee', 'シャワー料金を登録しました。');
        if($redirect === 'settings') return to_route('owner.settings')->with('success-optionFee', 'シャワー料金変更を登録しました');
    }

    public function mainteForm($type, $id)
    {
        switch ($type) {
            case('drivingRange'):
                $drivingRange = DrivingRange::findOrFail($id);
                return view('owner.mainte', compact('drivingRange', 'id'));
                break;

            case('rental'):
                $rental = Rental::findOrFail($id);
                return view('owner.mainte', compact('rental', 'id'));
                break;

            case('shower'):
                $shower = Shower::findOrFail($id);
                return view('owner.mainte', compact('shower', 'id'));
                break;

            default:
                return to_route('owner.settings');
                break;
        }
    }

    public function setNewMainte(MainteRequest $request, $type, $id)
    {
        switch ($type) {
            case 'drivingRange':
                $drivingRange = $request->validated();
                DrivingRange::findOrFail($id)->update($drivingRange);
                return to_route('owner.settings')->with('success-mainte', 'ドライビングレンジのメンテ日を更新しました');
                break;

            case 'rental':
                $rental = $request->validated();
                Rental::findOrFail($id)->update($rental);
                return to_route('owner.settings')->with('success-mainte', 'レンタルクラブのメンテ日を更新しました');
                break;

            case 'shower':
                $shower = $request->validated();
                Shower::findOrFail($id)->update($shower);
                return to_route('owner.settings')->with('success-mainte', 'シャワールームのメンテ日を更新しました');
                break;

            default:
                return to_route('owner.settings');
                break;
        }
    }

}
