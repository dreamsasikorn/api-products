<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'is_admin' => '1',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'user_normal',
                'email' => 'user@normal.com',
                'is_admin' => '0',
                'password' => bcrypt('123456')
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
