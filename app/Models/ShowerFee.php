<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowerFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'shower_fee',
        'effective_date'
    ];
}
