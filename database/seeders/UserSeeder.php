<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'test@test.com',
                'password' => bcrypt('Test1234!'),
                'name' => 'Test1',
                'surname' => 'Test1',
                'city' => 'Test1',
                'province' => 'Test1',
            ],
            [
                'email' => 'test1@test.com',
                'password' => bcrypt('Test1234!'),
                'name' => 'Test2',
                'surname' => 'Test2',
                'city' => 'Test2',
                'province' => 'Test2',
            ],
            [
                'email' => 'test2@test.com',
                'password' => bcrypt('Test1234!'),
                'name' => 'Test3',
                'surname' => 'Test3',
                'city' => 'Test3',
                'province' => 'Test3',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
