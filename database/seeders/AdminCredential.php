<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminCredential extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => "",
            'email' => 'admin@mysite.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
        ]);
    }
}
