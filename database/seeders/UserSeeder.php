<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'susanjacke.24@gmail.com'],
            [
                'name' => 'Administradora PuppyCare',
                'password' => bcrypt('12345678'),
                'id_number' => '123456789',
                'phone' => '9999999999',
                'address' => 'PuppyCare',
            ]
        );

        $user->assignRole('Administrador');
    }
}
