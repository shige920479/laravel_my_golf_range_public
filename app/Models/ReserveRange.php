<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ReserveRange extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'driving_range_id',
        'reserve_date',
        'start_time',
        'end_time',
        'number',
        'cancelled',
        'fee',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function drivingRange()
    {
        return $this->belongsTo(DrivingRange::class);
    }

    public function reserveRental()
    {
        return $this->hasOne(ReserveRental::class, 'reserve_range_id');
    }

    public function reserveShower()
    {
        return $this->hasOne(ReserveShower::class, 'reserve_range_id');
    }

    public static function booted()
    {
        static::deleting(function ($reserveRange) {
            DB::transaction(function () use ($reserveRange) {
                $reserveRange->reserveRental?->delete();
                $reserveRange->reserveShower?->delete();
            });
        });
    }
}
