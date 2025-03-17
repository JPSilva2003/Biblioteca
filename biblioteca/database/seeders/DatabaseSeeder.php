<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Editora;
use App\Models\Livro;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $editora1 = Editora::create(['nome' => 'Editora A']);
        $editora2 = Editora::create(['nome' => 'Editora B']);

        Livro::create([
            'isbn' => '978-3-16-148410-0',
            'nome' => 'Livro 1',
            'editora_id' => $editora1->id,
            'preco' => 49.90
        ]);

        Livro::create([
            'isbn' => '978-1-23-456789-7',
            'nome' => 'Livro 2',
            'editora_id' => $editora2->id,
            'preco' => 39.90
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
