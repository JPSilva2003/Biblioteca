<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Livro;

class RequisicaoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'livro_id' => Livro::factory(),
            'data_requisicao' => now(),
            'data_prevista_entrega' => now()->addDays(7),
            'status' => 'pendente', // ou devolvido, conforme precisares
        ];
    }
}
