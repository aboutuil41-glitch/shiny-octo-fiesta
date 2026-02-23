<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $admin = User::create([
            'name' => 'SuperNoob761',
            'email' => 'supernoob761@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $admin->assignRole('admin');

        $Member = User::create([
            'name' => 'Walid Boutuil',
            'email' => 'w.boutuil@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $Member->assignRole('member');
    }
}
