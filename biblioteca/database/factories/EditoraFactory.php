<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EditoraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company(),
            'morada' => $this->faker->address(),
            'email' => $this->faker->unique()->companyEmail(),
            'telefone' => $this->faker->phoneNumber(),
        ];
    }
}
