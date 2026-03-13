<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;                        // ← ajoute cette ligne
use Illuminate\Support\Facades\Hash;       // ← ajoute cette ligne

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@hotel.com',
            'password' => Hash::make('password'),
        ]);
    }
}