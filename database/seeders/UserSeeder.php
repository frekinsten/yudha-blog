<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'      => 'Admin',
            'username'  => 'admin',
            'email'     => 'admin@example.com',
            'password'  => Hash::make('admin123'),
            'is_active' => true,
        ]);
        $admin->assignRole('Admin');

        $jakaNugraha = User::create([
            'name'      => 'Jaka Nugraha',
            'username'  => 'jakanugraha',
            'email'     => 'jakanugraha@example.com',
            'password'  => Hash::make('jakanugraha123'),
            'is_active' => true,
        ]);
        $jakaNugraha->assignRole('Writer');
    }
}
