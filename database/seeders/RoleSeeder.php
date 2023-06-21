<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * roles
     *
     * @var array
     */
    protected $roles = [
        ['name' => 'Admin', 'guard_name' => 'web'],
        ['name' => 'Writer', 'guard_name' => 'web'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'create category',
            'read category',
            'update category',
            'delete category',

            'create tag',
            'read tag',
            'update tag',
            'delete tag',

            'create post',
            'read post',
            'update post',
            'delete post',

            'create user',
            'read user',
            'update user',
            'delete user',
            'validate user',
        ]);

        $writer = Role::create(['name' => 'Writer', 'guard_name' => 'web']);
        $writer->syncPermissions([
            'create category',
            'read category',
            'update category',

            'create tag',
            'read tag',
            'update tag',

            'create post',
            'read post',
            'update post',
            'delete post',

            'read user',
            'update user',
        ]);
    }
}
