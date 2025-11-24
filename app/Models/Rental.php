<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'mainte_date',
        'del_flag',
    ];

    public function reserveRentals()
    {
        return $this->hasMany(ReserveRental::class, 'rental_id');
    }
}
