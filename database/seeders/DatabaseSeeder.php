<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::unprepared("CREATE SCHEMA IF NOT EXISTS lbaw2313");
        $path = base_path('db/schema.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $path = base_path('db/population.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $this->command->info('Database seeded!');
    }
}
