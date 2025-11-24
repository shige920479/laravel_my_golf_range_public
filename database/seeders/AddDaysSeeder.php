<?php

namespace Database\Seeders;

use App\Models\ReserveRange;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseDate = ReserveRange::orderBy('reserve_date')->first()->reserve_date;
        $today = Carbon::today()->format('Y-m-d');
        $addWeek = Carbon::parse($baseDate)->diffInWeeks($today);
        $addDayFloat = floor($addWeek) * 7;
        $addDays = (int)$addDayFloat;

        DB::transaction(function () use ($addDays) {
            DB::update("UPDATE reserve_ranges SET reserve_date = DATE_ADD(reserve_date, INTERVAL {$addDays} DAY)");
            DB::update("UPDATE reserve_rentals SET reserve_date = DATE_ADD(reserve_date, INTERVAL {$addDays} DAY)");
            DB::update("UPDATE reserve_showers SET reserve_date = DATE_ADD(reserve_date, INTERVAL {$addDays} DAY)");
            DB::update("UPDATE driving_ranges SET mainte_date = DATE_ADD(mainte_date, INTERVAL {$addDays} DAY)");
            DB::update("UPDATE rentals SET mainte_date = DATE_ADD(mainte_date, INTERVAL {$addDays} DAY)");
            DB::update("UPDATE showers SET mainte_date = DATE_ADD(mainte_date, INTERVAL {$addDays} DAY)");
            DB::update("UPDATE range_fees SET effective_date = DATE_ADD(effective_date, INTERVAL {$addDays} DAY) ORDER BY id DESC LIMIT 1");
            DB::update("UPDATE rental_fees SET effective_date = DATE_ADD(effective_date, INTERVAL {$addDays} DAY) ORDER BY id DESC LIMIT 1");
            DB::update("UPDATE shower_fees SET effective_date = DATE_ADD(effective_date, INTERVAL {$addDays} DAY) ORDER BY id DESC LIMIT 1");
        });
    }
}
