<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Elfrandt',
            'email' => 'elfrandtgold29@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        Driver::create([
            'name' => 'Pak Supir',
            'email' => 'driver@gmail.com',
            'password' => Hash::make('123456789'),
            'drivers_license_number' => 'SIM-123456',
            'license_plate' => 'B 3614 KLT',
        ]);
    }
}