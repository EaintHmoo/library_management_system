<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UserTableSeeder::class,
            RoleUserTableSeeder::class,
            GeneralTableSeeder::class,
        ]);
    }
}
