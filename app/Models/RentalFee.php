<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_fee',
        'effective_date'
    ];
}
