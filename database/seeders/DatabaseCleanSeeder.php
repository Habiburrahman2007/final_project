<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseCleanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();
        DB::table('articles')->truncate();
        DB::table('likes')->truncate();
        DB::table('comments')->truncate();
        // tambahkan tabel lain sesuai kebutuhan

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
