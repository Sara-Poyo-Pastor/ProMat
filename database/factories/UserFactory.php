<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'lastname' => $this->faker->lastname,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password, // Puedes usar valores predeterminados o faker para generar contraseñas aleatorias.
        ];
    }
}

