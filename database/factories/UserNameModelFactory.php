<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Model;
use Faker\Generator as Faker;

class ModelFactory extends Factory
{
    protected $model = Model::class;

    public function definition()
    {
        return [
            //
        ];
    }
}