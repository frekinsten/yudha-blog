<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->paragraph(1),
            'post_id' => Post::get()->random()->id,
            'user_id' => User::get()->random()->id,
            'parent_id' => $this->faker->optional(0.7)->randomDigitNotZero(),
        ];
    }
}
