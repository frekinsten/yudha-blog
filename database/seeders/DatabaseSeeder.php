<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\{
    CategorySeeder,
    TagSeeder,
    RoleSeeder,
    PermissionSeeder,
    UserSeeder,
    PostSeeder,
    CommentSeeder,
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            // PostSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}
