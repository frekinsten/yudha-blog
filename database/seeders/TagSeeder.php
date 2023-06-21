<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
            ['tag_name'  => 'Foto', 'slug' => 'foto'],
            ['tag_name'  => 'Video', 'slug' => 'video'],
        ]);
    }
}
