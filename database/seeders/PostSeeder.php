<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = File::allFiles(public_path('storage/image-cover'));
        if (count($images) > 0) {
            foreach ($images as $image) {
                File::delete(public_path('storage/image-cover/' . $image->getFilename()));
            }
        }

        Post::factory()->count(10)->create();
        $tags = Tag::get(['id']);

        Post::get()->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(2, count($tags)))->pluck('id')->toArray(),
            );
        });
    }
}
