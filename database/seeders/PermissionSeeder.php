<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    protected $permissions = [
        ['name'  => 'create category', 'guard_name' => 'web'],
        ['name'  => 'read category', 'guard_name' => 'web'],
        ['name'  => 'update category', 'guard_name' => 'web'],
        ['name'  => 'delete category', 'guard_name' => 'web'],

        ['name'  => 'create tag', 'guard_name' => 'web'],
        ['name'  => 'read tag', 'guard_name' => 'web'],
        ['name'  => 'update tag', 'guard_name' => 'web'],
        ['name'  => 'delete tag', 'guard_name' => 'web'],

        ['name'  => 'create post', 'guard_name' => 'web'],
        ['name'  => 'read post', 'guard_name' => 'web'],
        ['name'  => 'update post', 'guard_name' => 'web'],
        ['name'  => 'delete post', 'guard_name' => 'web'],

        ['name'  => 'create user', 'guard_name' => 'web'],
        ['name'  => 'read user', 'guard_name' => 'web'],
        ['name'  => 'update user', 'guard_name' => 'web'],
        ['name'  => 'delete user', 'guard_name' => 'web'],
        ['name'  => 'validate user', 'guard_name' => 'web'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $permission) {
            Permission::create($permission);
        }
    }
}
