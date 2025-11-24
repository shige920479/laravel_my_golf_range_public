<?php

namespace App\Http\Controllers;

use App\Models\RangeFee;
use App\Models\RentalFee;
use App\Models\ShowerFee;
use Carbon\Carbon;


class GuestController extends Controller
{
    public function showPrice()
    {
        $rangeFee = RangeFee::orderby('effective_date', 'desc')->limit(2)->get();
        $rentalFee = rentalFee::orderby('effective_date', 'desc')->limit(2)->get();
        $showerFee = showerFee::orderby('effective_date', 'desc')->limit(2)->get();
        
        if($rangeFee->first()->effective_date <= Carbon::today()) {
            $rangeFee = $rangeFee->take(1);
        }
        if($rentalFee->first()->effective_date <=  Carbon::today()) {
            $rentalFee = $rentalFee->take(1);
        }
        if($showerFee->first()->effective_date <=  Carbon::today()) {
            $showerFee = $showerFee->take(1);
        }
        
        return view('price', compact('rangeFee', 'rentalFee','showerFee'));
    }
}
