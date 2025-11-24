<?php
namespace App\Services;

use App\Models\DrivingRange;
use App\Models\Rental;
use App\Models\ReserveRange;
use App\Models\ReserveRental;
use App\Models\ReserveShower;
use App\Models\Shower;
use Auth;
use Carbon\Carbon;
use Constant;
use Illuminate\Support\Facades\Redirect;

class CheckReservationService
{
  // 予約・変更・キャンセル可能な時間帯か判定（1時間前まで）
  public static function validateReservationTime(string $reserveDate, string $startTime)
  {
    $errors = [];
    $now = Carbon::now();
    if(Carbon::parse($reserveDate)->isSameDay($now)) {
      if(Carbon::parse($startTime)->diffInMinutes($now) < Constant::CHANGEABLE_TIME) {
        $errors['start_time'] = "登録・変更・キャンセルは1時間前迄です";
        return Redirect::back()->withErrors($errors)->withInput();
      }
    }
    return true;
  }

  // メンテナンス日か、他の予約と重複していないか判定
  public static function checkMainteAndReserved(array $request, ?int $id = null)
  {   
    $errors = [];
    $mainte_date = DrivingRange::where('id', $request['driving_range_id'])->first()->mainte_date;
    
    if($request['reserve_date'] === $mainte_date) {
      $errors['driving_range_id'] = 'メンテナンス日の為、ご利用できません';
    } else {
      $query = ReserveRange::where('reserve_date', $request['reserve_date'])
                ->where('driving_range_id', $request['driving_range_id'])
                ->where('end_time', '>', $request['start_time'])->where('start_time', '<', $request['end_time']);
      
      if($id) $query->where('id', '!=', $id);

      if($query->exists()) {
        $errors['start_time'] = "この時間帯は既に予約で埋まっています";
      }
    }

    if(! empty($request['rental'])) {
      if(is_null($request['rental_id'])) {
        $errors['rental_id'] = '選択してください';
      } else {
        $mainte_date = Rental::where('id', $request['rental_id'])->first()->mainte_date;
        if($request['reserve_date'] === $mainte_date) {
          $errors['rental_id'] = 'メンテナンス日の為、ご利用できません';
        } else{
          $query  = ReserveRental::where('reserve_date', $request['reserve_date'])
                    ->where('rental_id', $request['rental_id'])
                    ->where('end_time', '>', $request['start_time'])->where('start_time', '<', $request['end_time']);
          if($id) $query->where('reserve_range_id', '!=', $id);

          if($query->exists()) $errors['rental_id'] = "この時間帯は既に予約で埋まっています";
        }
      }
    } else {
      if(isset($request['rental_id'])) {
        $errors['rental_id'] = "「利用する」をチェックして下さい";
      }
    }

    if(! empty($request['shower'])) {
      if(is_null($request['shower_time'])) {
        $errors['shower_time'] = "時間を指定してください";
      } else {
        $mainte_date = Shower::first()->mainte_date;
        if($request['reserve_date'] === $mainte_date) {
          $errors['shower_time'] = 'メンテナンス日の為、ご利用できません';
        } else {
          $query = ReserveShower::where('reserve_date', $request['reserve_date'])
                    ->where('shower_time', $request['shower_time']);
          if($id) $query->where('reserve_range_id', '!=', $id);
          if($query->exists()) $errors['shower_time'] = "この時間帯は既に予約で埋まっています";
        }
      }
    } else {
      if(isset($request['shower_time'])) {
        $errors['shower_time'] = "「利用する」をチェックして下さい";
      }
    }
    
    return ! empty($errors) ? Redirect::back()->withErrors($errors)->withInput() : true;
  }

  // 同一時間帯に自分の予約と重複していないか判定
  public static function checkDoubleBook(array $request, ?int $id = null)
  {
    $queryRange = ReserveRange::where('reserve_date',$request['reserve_date'])
                  ->where('user_id', Auth::id())
                  ->where('start_time', '<', $request['end_time'])
                  ->where('end_time', '>', $request['start_time']);
    if($id) $queryRange->where('id', '!=', $id);
    if($queryRange->exists()) $errors['start_time'] = '同一時間帯に他の予約があります。';

    if(empty($request['shower']) && ! is_null($request['shower_time'])) {
      $queryShower = ReserveShower::where('reserve_date',$request['reserve_date'])
                    ->where('user_id', Auth::id())
                    ->where('shower_time', $request['shower_time']);
      if($id) $queryShower->where('reserve_range_id', '!=', $id);
      if($queryShower->exists()) $errors['shower_time'] = '既に予約済です。';
    }

    return ! empty($errors) ? Redirect::back()->withErrors($errors)->withInput() : true;

  }

}
