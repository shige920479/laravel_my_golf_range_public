<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReserveRental extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'rental_id',
        'reserve_range_id',
        'reserve_date',
        'start_time',
        'end_time',
        'cancelled',
        'fee',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function rental(){
        return $this->belongsTo(Rental::class);
    }

    public function reserveRange()
    {
        return $this->belongsTo(ReserveRange::class);
    }
}
