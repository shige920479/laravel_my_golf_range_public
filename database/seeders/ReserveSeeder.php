<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReserveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFiles = [
            'sql/reserveRange.sql',
            'sql/reserveRental.sql',
            'sql/reserveShower.sql',
        ];

        DB::transaction(function () use ($sqlFiles) {
            foreach($sqlFiles as $file) {
                DB::unprepared(file_get_contents(database_path($file)));
            }
        });

    }
}
