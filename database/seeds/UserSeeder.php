<?php

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
        User::insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@a.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Guru',
                'username' => 'guru',
                'email' => 'guru@a.com',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@a.com',
                'password' => Hash::make('user123'),
                'role' => 'siswa',
            ]
        ]);
    }
}
