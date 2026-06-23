<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver; 
use App\Models\Vehicle;
use App\Models\Cs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'elfrandtgold29@gmail.com'],
            [
                'name' => 'Elfrandt',
                'password' => Hash::make('123456789'),
            ]
        );

        $bike = Vehicle::firstOrCreate(
            ['name_vehicle' => 'bike'],
            ['display_name' => 'Motorcycle']
        );

        $car = Vehicle::firstOrCreate(
            ['name_vehicle' => 'car'],
            ['display_name' => 'Car']
        );

        Driver::firstOrCreate(
            ['email' => 'driver@gmail.com'],
            [
                'name' => 'Pak Supir',
                'password' => Hash::make('123456789'),
                'drivers_license_number' => 'SIM-123456',
                'vehicle_type_id' => $bike->id, 
                'license_plate' => 'B 3614 KLT',
            ]
        );

        Cs::firstOrCreate(
            ['email' => 'RichieGanteng@gmail.com'],
            [
                'name' => 'Richie Customer Service',
                'password' => Hash::make('123456789'),
            ]
        );
    }
}