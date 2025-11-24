<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shower extends Model
{
    use HasFactory;

    protected $fillable = [
        'mainte_date',
        'del_flag',
    ];
}
