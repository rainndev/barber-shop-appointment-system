<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BarberUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'barber@barbershop.test'],
            [
                'name' => 'Lead Barber',
                'role' => 'barber',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'barber2@barbershop.test'],
            [
                'name' => 'Junior Barber',
                'role' => 'barber',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}