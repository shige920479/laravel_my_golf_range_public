<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\DrivingRange;
use App\Models\Rental;
use Illuminate\Http\Request;

class InitSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');
    }
    
    public function initForm()
    {   
        return view('owner.init');
    }

    public function setDrivingRange(Request $request)
    {
        
        $validated = $request->validate([
            'name.*' => ['required', 'string', 'max:50']
        ]);

        for($i = 0; $i < count($validated); $i++) {
            foreach($validated as $key => $value) {
                $inputArray[$key] = $value[$i];
            }
            DrivingRange::create($inputArray);
        }
        return to_route('owner.initForm')->with('success-drivingRange', 'ドライビングレンジを登録しました');
    }

    public function setRental(Request $request)
    {
        $validated = $request->validate([
            'brand.*' => ['required', 'string', 'max:50'],
            'model.*' => ['required', 'string', 'max:50'],
        ]);

        for($i = 0; $i < count($validated); $i++) {
            foreach($validated as $key => $value) {
                $inputArray[$key] = $value[$i];
            }
            Rental::create($inputArray);
        }
        return to_route('owner.initForm')->with('success-rental', 'レンタルクラブを登録しました');
    }
}
