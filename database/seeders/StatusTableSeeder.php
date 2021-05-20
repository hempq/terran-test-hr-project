<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Active', 'Inactive'];

        foreach ($types as $type) {
            DB::table('status')->insert([
                'name' => $type,
            ]);
        }
    }
}