<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $title = $this->faker->sentence(5, false);
        $slug = Str::slug($title);

        $paragraphs = $this->faker->paragraphs(rand(15, 20));
        $desc = "";
        foreach ($paragraphs as $para) {
            $desc .= "<p>{$para}</p>";
        }

        return [
            'title' => $title,
            'slug' => $slug,
            'desc' => $desc,
            'img_cover' => $this->faker->image(public_path('storage/image-cover'), 1098, 500, null, false),
            'category_id' => Category::get(['id'])->random(),
            'user_id' => User::get(['id'])->random(),
        ];
    }
}
