<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Classic Haircut', 'description' => 'Clean haircut and finishing style.', 'duration_minutes' => 30, 'price' => 15.00],
            ['name' => 'Haircut + Beard Trim', 'description' => 'Haircut with a sharp beard tidy-up.', 'duration_minutes' => 45, 'price' => 25.00],
            ['name' => 'Premium Grooming', 'description' => 'Full grooming package with hot towel finish.', 'duration_minutes' => 60, 'price' => 35.00],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['name' => $service['name']],
                $service + ['is_active' => true]
            );
        }
    }
}
