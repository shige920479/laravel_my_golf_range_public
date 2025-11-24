<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFiles = [
            'sql/rangeFee.sql',
            'sql/rentalFee.sql',
            'sql/showerFee.sql'
        ];

        DB::transaction(function () use ($sqlFiles) {
            foreach($sqlFiles as $file) {
                DB::unprepared(file_get_contents(database_path($file)));
            }
        });
    }
}
