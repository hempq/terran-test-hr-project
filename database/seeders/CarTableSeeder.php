<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Car;

class CarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $licensPlates = ['HOA-310', 'TLL-150', 'EXD-948', 'VQQ-948', 'ITA-501', 'EOY-183', 'FPQ-705', 'KJK-209', 'YXZ-753'];
        $brand = ['Lada', 'Acura', 'BMW', 'Bentley', 'Cadillac', 'Chevrolet', 'Audi', 'Alfa Romeo'];
        foreach ($licensPlates as $licensPlate) {
            Car::create([
                'user_id' => rand(1,9),
                'license_plate_number' => $licensPlate,
                'brand' => $brand[array_rand($brand, 1)],
                'vintage' => rand(1980, 2020),        
                'smd' => rand(50000, 250000),        
                'status_id' => 1,
            ]);
        }
    }
}
