<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        return [
            'Title' => $this->faker->title,
            'post' => $this->faker->realText(1000),
            'Image' => $this->faker->title,
            'category_id' => 1,
            'user_id' => User::find(1)->id
        ];
    }
}