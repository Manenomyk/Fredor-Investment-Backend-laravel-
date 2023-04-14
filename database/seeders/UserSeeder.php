<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Admin',
            'email'=>'admin@fredor.com',
            'password'=>Hash::make('fredorinvestments'),
            'phone_number'=>'123456789',
            'id_number'=>'123456789',
            'location'=>'Kenya',
            'designition'=>3,
            'email_verified_at' =>now(),
        ]);
    }
}
