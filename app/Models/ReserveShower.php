<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReserveShower extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'reserve_range_id',
        'reserve_date',
        'shower_time',
        'cancelled',
        'fee',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function reserveRange()
    {
        return $this->belongsTo(ReserveRange::class);
    }
}
