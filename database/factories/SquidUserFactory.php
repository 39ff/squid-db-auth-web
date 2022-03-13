<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SquidUser>
 */
class SquidUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user' => Str::random(10),
            'password' => Str::random(10),
            'enabled'=>1,
            'fullname'=>$this->faker->name(),
            'comment'=> Str::random(20)
        ];
    }
}
