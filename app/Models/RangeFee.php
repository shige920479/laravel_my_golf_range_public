<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangeFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrance_fee',
        'weekday_fee',
        'holiday_fee',
        'effective_date'
    ];
}
