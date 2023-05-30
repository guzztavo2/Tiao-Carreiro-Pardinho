<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $user = new User();
        // $user->createToken('user');
        // $user->name = fake()->name();
        // $user->password = '123';
        // return
        return [
            'name' => fake()->name(),
            'password' => '123', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
}
