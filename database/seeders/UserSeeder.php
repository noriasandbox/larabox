<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::updateOrCreate(
            ['email' => 'master@larabox.dev'],
            [
                'surname' => 'Demo',
                'name' => 'Master User',
                'phone_number' => '254710000001',
                'password' => bcrypt('pass_12345'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@larabox.dev'],
            [
                'surname' => 'Demo',
                'name' => 'Admin User',
                'phone_number' => '254710000002',
                'password' => bcrypt('pass_12345'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'moderator@larabox.dev'],
            [
                'surname' => 'Demo',
                'name' => 'Moderator User',
                'phone_number' => '254710000003',
                'password' => bcrypt('pass_12345'),
                'email_verified_at' => now(),
            ]
        );
    }
}
