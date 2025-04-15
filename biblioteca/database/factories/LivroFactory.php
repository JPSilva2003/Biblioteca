<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LivroFactory extends Factory
{
    public function definition(): array
    {
        return [
            'isbn' => $this->faker->isbn13(),
            'nome' => $this->faker->sentence(3),
            'editora_id' => 1, // ou usa Editora::factory() se tiveres a relação
            'autores' => $this->faker->name(),
            'bibliografia' => $this->faker->paragraph(),
            'imagem_capa' => $this->faker->imageUrl(),
            'preco' => $this->faker->randomFloat(2, 10, 100),
            'disponivel' => 1,
        ];
    }
}
