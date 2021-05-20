<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'phone' => $this->randomNumberSequence(),
            'type_id' => 1,
            'status_id' => 1,
        ]);

        User::create([
            'name' => 'Normal',
            'email' => 'normal@example.com',
            'password' => bcrypt('normal'),
            'phone' => $this->randomNumberSequence(),
            'type_id' => 2,
            'status_id' => 1,
        ]);

        // Users pagination
        // I know how to use factories, I just wanted to add it.
        $people = ['Kiss Pista', 'Vég Béla', 'Nyomo Réka', 'Szalmon Ella', 'Git Áron', 'Fejet Lenke', 'Har Mónika'];

        foreach ($people as $person) {
            User::create([
                'name' => $person,
                'email' =>  strtolower(str_replace('\'', '',  iconv('utf-8', 'ascii//TRANSLIT', str_replace(' ', '.', $person)).'@example.com')),
                'password' => bcrypt('secret'),
                'phone' => $this->randomNumberSequence(),
                'type_id' => 2,
                'status_id' => 1,
            ]);
        }

    }

    private function randomNumberSequence($requiredLength = 7, $highestDigit = 9) {
        $numberPrefixes = ['20', '30', '70'];
        $sequence = '';
        for ($i = 0; $i < $requiredLength; ++$i) {
            $sequence .= mt_rand(0, $highestDigit);
        }
        for ($i = 0; $i < 2; ++$i) {
            return '+36'.$numberPrefixes[array_rand($numberPrefixes)].$sequence;
        }
    }
}
