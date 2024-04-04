<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 18,
                'title' => 'author_create',
            ],
            [
                'id'    => 19,
                'title' => 'author_edit',
            ],
            [
                'id'    => 20,
                'title' => 'author_show',
            ],
            [
                'id'    => 21,
                'title' => 'author_delete',
            ],
            [
                'id'    => 22,
                'title' => 'author_access',
            ],
            [
                'id'    => 23,
                'title' => 'book_category_create',
            ],
            [
                'id'    => 24,
                'title' => 'book_category_edit',
            ],
            [
                'id'    => 25,
                'title' => 'book_category_show',
            ],
            [
                'id'    => 26,
                'title' => 'book_category_delete',
            ],
            [
                'id'    => 27,
                'title' => 'book_category_access',
            ],
            [
                'id'    => 28,
                'title' => 'publisher_create',
            ],
            [
                'id'    => 29,
                'title' => 'publisher_edit',
            ],
            [
                'id'    => 30,
                'title' => 'publisher_show',
            ],
            [
                'id'    => 31,
                'title' => 'publisher_delete',
            ],
            [
                'id'    => 32,
                'title' => 'publisher_access',
            ],
            [
                'id'    => 33,
                'title' => 'book_create',
            ],
            [
                'id'    => 34,
                'title' => 'book_edit',
            ],
            [
                'id'    => 35,
                'title' => 'book_show',
            ],
            [
                'id'    => 36,
                'title' => 'book_delete',
            ],
            [
                'id'    => 37,
                'title' => 'book_access',
            ],
            [
                'id'    => 38,
                'title' => 'member_create',
            ],
            [
                'id'    => 39,
                'title' => 'member_edit',
            ],
            [
                'id'    => 40,
                'title' => 'member_show',
            ],
            [
                'id'    => 41,
                'title' => 'member_delete',
            ],
            [
                'id'    => 42,
                'title' => 'member_access',
            ],
            [
                'id'    => 43,
                'title' => 'location_create',
            ],
            [
                'id'    => 44,
                'title' => 'location_edit',
            ],
            [
                'id'    => 45,
                'title' => 'location_show',
            ],
            [
                'id'    => 46,
                'title' => 'location_delete',
            ],
            [
                'id'    => 47,
                'title' => 'location_access',
            ],
            [
                'id'    => 48,
                'title' => 'checkout_create',
            ],
            [
                'id'    => 49,
                'title' => 'checkout_edit',
            ],
            [
                'id'    => 50,
                'title' => 'checkout_show',
            ],
            [
                'id'    => 51,
                'title' => 'checkout_delete',
            ],
            [
                'id'    => 52,
                'title' => 'checkout_access',
            ],
            [
                'id'    => 53,
                'title' => 'library_setting_access',
            ],
            [
                'id'    => 54,
                'title' => 'fine_create',
            ],
            [
                'id'    => 55,
                'title' => 'fine_edit',
            ],
            [
                'id'    => 56,
                'title' => 'fine_show',
            ],
            [
                'id'    => 57,
                'title' => 'fine_delete',
            ],
            [
                'id'    => 58,
                'title' => 'fine_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
