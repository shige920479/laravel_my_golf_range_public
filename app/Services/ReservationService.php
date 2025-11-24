<?php
namespace App\Services;

use App\Models\RangeFee;
use App\Models\Rental;
use App\Models\RentalFee;
use App\Models\ShowerFee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationService
{
  public static function getDailyReserveData(String $searchDate)
  {
    $allData = DB::select("SELECT
    'driving_ranges' AS type, dr.id AS facility_id, dr.name AS facility_name,
    dr.mainte_date, rra.user_id, rra.reserve_date, rra.start_time, rra.end_time
    FROM driving_ranges AS dr
    LEFT JOIN reserve_ranges AS rra ON dr.id = rra.driving_range_id
    AND rra.reserve_date = ?
    AND rra.deleted_at IS NULL
    UNION ALL
    SELECT 
    'rentals' AS type,
    re.id AS facility_id, CONCAT(re.brand, ' ', re.model) AS facility_name,
    re.mainte_date, rre.user_id, rre.reserve_date, rre.start_time, rre.end_time
    FROM rentals AS re
    LEFT JOIN reserve_rentals AS rre ON re.id = rre.rental_id
    AND rre.reserve_date = ?
    AND rre.deleted_at IS NULL
    UNION ALL
    SELECT 
    'showers' AS type, sh.id AS facility_id, 'シャワー室' AS facility_name,
    sh.mainte_date, rsh.user_id, rsh.reserve_date, rsh.shower_time AS start_time,
    NULL AS end_time
    FROM showers AS sh
    LEFT JOIN reserve_showers AS rsh ON rsh.reserve_date = ?
    AND rsh.deleted_at IS NULL
    ORDER BY type, facility_id, reserve_date, start_time",
    [$searchDate, $searchDate, $searchDate]);

    return collect($allData)->groupBy(fn($item) => "{$item->type}_{$item->facility_id}");
  }

  public static function calcFee(Object $request)
  {
    $usageTime = Carbon::parse($request->start_time)->floatDiffInHours($request->end_time);

    //レンジ料金の計算
    $setupFeeRange = RangeFee::where('effective_date', '<=', $request->reserve_date)
    ->orderBy('effective_date','desc')->first();
    $entranceFee = (int)$request->number * $setupFeeRange->entrance_fee;
    if(Carbon::parse($request->reserve_date)->isWeekday()) {
      $rangeFee = $setupFeeRange->weekday_fee * $usageTime;
    } else {
      $rangeFee = $setupFeeRange->holiday_fee * $usageTime;
    }

    //レンタル料金の計算
    if(! is_null($request->rental)) {
      $setupFeeRental = RentalFee::where('effective_date', '<=', $request->reserve_date)
      ->orderBy('effective_date','desc')->first();
      $rentalFee = $setupFeeRental->rental_fee * $usageTime;
    } else {
      $rentalFee = 0;
    }

    //シャワー料金の計算
    if(! is_null($request->shower)) {
      $setupFeeShower = ShowerFee::where('effective_date', '<=', $request->reserve_date)
      ->orderBy('effective_date','desc')->first();
      $showerFee = $setupFeeShower->shower_fee;
    } else {
      $showerFee = 0;
    }

    //4つの料金を返却
    return [$entranceFee, $rangeFee, $rentalFee, $showerFee];


  }
}
