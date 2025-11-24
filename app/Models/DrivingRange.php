<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mainte_date',
        'del_flag'
    ];

    public function reserveRanges()
    {
        return $this->hasMany(ReserveRange::class);
    }
}
