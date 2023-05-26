<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'dev.miptha@gmail.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now()
        ])->assignRole('admin');

        User::create([
            'name' => 'anggota',
            'email' => 'anggota@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ])->assignRole('anggota');

      
    }
}
