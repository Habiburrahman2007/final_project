<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(ArticleSeeder::class);

        User::create([
            'name' => 'Admin',
            'email' => 'habib@gmail.com',
            'profession' => 'Pengangguran',
            'photo_profile' => null,
            'bio' => null,
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Karina',
            'email' => 'aespa@gmail.com',
            'profession' => 'Graphic Designer',
            'photo_profile' => null,
            'bio' => null,
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Eko',
            'email' => 'sepuh@gmail.com',
            'profession' => 'Fullstack Developer',
            'photo_profile' => null,
            'bio' => null,
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);
    }
}
