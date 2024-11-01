<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                => 1,
                'name'              => 'Admin',
                'email'             => 'admin@admin.com',
                'password'          => bcrypt('password'),
                'remember_token'    => null,
                'uuid'              => '',
                'nik'               => '',
                'job_position_code' => '',
                'job_position_text' => '',
                'unit_code'         => '',
                'unit_name'         => '',
            ],
        ];

        User::insert($users);
    }
}
