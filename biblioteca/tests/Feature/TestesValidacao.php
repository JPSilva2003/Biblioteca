<?php

use App\Models\User;
use App\Models\Livro;
use App\Models\Requisicao;
use function Pest\Laravel\post;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

// ✅ 1. Teste de criação de requisição de livro
it('1. Cria uma requisição de livro com sucesso', function () {
    // Criar um utilizador e um livro disponível
    $user = User::factory()->create();
    $livro = Livro::factory()->create([
        'disponivel' => 1,
        'autores' => 'Machado de Assis',
    ]);

    // Simular login e criar a requisição
    actingAs($user)
        ->post('/requisicoes', [
            'livro_id' => $livro->id,
        ])
        ->assertStatus(302); // A ação redireciona após criar

    // Verificar que a requisição foi criada corretamente
    expect(Requisicao::count())->toBe(1);
    $req = Requisicao::first();
    expect($req->livro_id)->toBe($livro->id)
        ->and($req->user_id)->toBe($user->id);
});


// ❌ 2. Teste de validação de livro inválido
it('2. Não permite requisição sem livro válido', function () {
    $user = User::factory()->create();

    // Tentar criar requisição sem fornecer um livro
    actingAs($user)
        ->post('/requisicoes', [
            'livro_id' => null,
        ])
        ->assertSessionHasErrors('livro_id'); // Espera erro de validação
});


// 🔄 3. Teste de devolução de livro
it('3. Permite devolução de livro', function () {
    // Criar utilizador, livro indisponível e uma requisição ativa
    $user = User::factory()->create();
    $livro = Livro::factory()->create(['disponivel' => false]);
    $requisicao = Requisicao::factory()->create([
        'livro_id' => $livro->id,
        'user_id' => $user->id,
        'status' => 'pendente',
    ]);

    // Simular devolução do livro
    actingAs($user)
        ->patch("/requisicoes/{$requisicao->id}/confirmar")
        ->assertRedirect(route('requisicoes.index')); // Redireciona após devolver

    // Verificar que o estado da requisição mudou e o livro está disponível
    $requisicao->refresh();
    $livro->refresh();

    expect($requisicao->status)->toBe('Concluída')
        ->and($livro->disponivel)->toBe(1);
});


// 📄 4. Teste de listagem de requisições do utilizador
it('4. Lista apenas requisições do utilizador', function () {
    // Criar dois utilizadores e dois livros
    $user1 = User::factory()->create(['name' => 'Utilizador Um']);
    $user2 = User::factory()->create(['name' => 'Utilizador Dois']);
    $livro1 = Livro::factory()->create();
    $livro2 = Livro::factory()->create();

    // Criar requisições para os dois utilizadores
    Requisicao::factory()->create([
        'user_id' => $user1->id,
        'livro_id' => $livro1->id,
    ]);
    Requisicao::factory()->create([
        'user_id' => $user2->id,
        'livro_id' => $livro2->id,
    ]);

    // Verifica se ao fazer login como o user1, só aparecem as suas requisições
    $response = actingAs($user1)->get('/requisicoes');

    $response->assertSee('Utilizador Um'); // Deve ver-se
    $response->assertDontSee('Utilizador Dois'); // Não deve ver-se
});


// ❌ 5. Teste de livro indisponível
it('5. Impede requisição se livro estiver indisponível', function () {
    $user = User::factory()->create();

    // Criar livro indisponível
    $livro = Livro::factory()->create([
        'disponivel' => false,
    ]);

    // Tentar requisitar o livro
    $response = actingAs($user)->post('/requisicoes', [
        'livro_id' => $livro->id,
    ]);

    // Verificar que a aplicação rejeita e mostra erro
    $response->assertSessionHas('error', 'Este livro já foi requisitado e está indisponível.');
});
