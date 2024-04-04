<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,

            ],
            [
                'id'                 => 2,
                'name'               => 'Librarian',
                'email'              => 'librarian@gmail.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
            ],
            [
                'id'                 => 3,
                'name'               => 'Reader',
                'email'              => 'reader@gmail.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
            ],
        ];

        User::insert($users);

        //Memember

        $members = [
            [
                'id' => 1,
                'member_no' => 'MN_000001',
                'date_of_membership' => date('Y-m-d'),
                'date_of_birth' => date('Y-m-d', strtotime('1-1-2000')),
                'address'   => 'Yangon',
                'phone_no'  => '09222333444',
                'user_id'   => '3',
            ]
        ];

        Member::insert($members);
    }
}
