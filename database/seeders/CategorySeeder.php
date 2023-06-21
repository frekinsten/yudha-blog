<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['category_name' => 'Programming', 'slug' => 'programming'],
            ['category_name' => 'DevOps', 'slug' => 'food'],
            ['category_name' => 'Artificial Intelligence', 'slug' => 'artificial-intelligence'],
        ]);
    }
}
