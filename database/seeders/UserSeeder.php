<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // Database\Seeders\UserSeeder.php
    public function run(): void
    {
        // Create a doctor
        $doctor = User::create([
            'id' => 1,
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => '1', // 1 for Admin (Doctor)
            'specialization' => 'General Practitioner',
        ]);

        // Create patients and assign them to the doctor
        User::create([
            'id' => 2,
            'name' => 'User 1',
            'username' => 'user1',
            'email' => 'user1@user.com',
            'password' => bcrypt('password'),
            'role' => '0', // 0 for User
            'doctor_id' => $doctor->id, // Associate with doctor
            'disease' => 'Flu',
        ]);

        User::create([
            'id' => 3,
            'name' => 'User 2',
            'username' => 'user2',
            'email' => 'user2@user.com',
            'password' => bcrypt('password'),
            'role' => '0', // 0 for User
            'doctor_id' => $doctor->id, // Associate with doctor
            'disease' => 'Cold',
        ]);
    }

}
