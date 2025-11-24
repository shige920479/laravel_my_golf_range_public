<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFiles = [
            'sql/temp_users.sql',
            'sql/users.sql'
        ];

        DB::transaction(function () use ($sqlFiles) {
            foreach($sqlFiles as $file) {
                DB::unprepared(file_get_contents(database_path($file)));
            }
        });
    }
}
