<x-app-layout>
    <div class="container">
        <h2 class="mb-4">
            {{ auth()->user()->role_id == 1 ? '🛠️ Painel de notificaçoes gerais (Admin)' : '🔔 Minhas Notificaçoes' }}
        </h2>

        @foreach ($reviews as $review)
        <strong>📚 Reviews</strong>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5><strong>📖 Livro:</strong> {{ $review->requisicao->livro->nome ?? 'Desconhecido' }}</h5>

                {{-- Mostrar nome do user se for admin --}}
                @if(auth()->user()->role_id == 1)
                <p><strong>👤 Utilizador:</strong> {{ $review->user->name }}</p>
                @endif

                <p><strong>📰 Comentario: </strong>{{ $review->conteudo }}</p>

                <p><strong>Estado:</strong>
                    <span class="badge
                        @if($review->estado == 'ativo') bg-success
                        @elseif($review->estado == 'recusado') bg-danger
                        @else bg-secondary @endif">
                        {{ ucfirst($review->estado) }}
                    </span>
                </p>

                @if($review->justificacao)
                <p><strong>Justificação:</strong> {{ $review->justificacao }}</p>
                @endif

                {{-- Mostrar form de update só se for admin --}}
                @if(auth()->user()->role_id == 1)
                <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')

                    <div class="mb-2">
                        <select name="estado" class="form-select" required>
                            <option value="">Alterar estado</option>
                            <option value="ativo" {{ $review->estado == 'ativo' ? 'selected' : '' }}>Aprovar</option>
                            <option value="recusado" {{ $review->estado == 'recusado' ? 'selected' : '' }}>Recusar</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <input type="text" name="justificacao" class="form-control" placeholder="Justificação (opcional)" value="{{ $review->justificacao }}">
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">💾 Atualizar Estado</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach

        <hr class="my-4">
        <h3 class="text-secondary">🔔 Alertas de Livros Disponíveis</h3>

        @php
        $alertas = \App\Models\AlertaLivro::with('livro')
        ->where('user_id', auth()->id())
        ->where('notificado', true)
        ->latest()
        ->get();
        @endphp

        @if($alertas->isEmpty())
        <p class="text-muted">Ainda não tens alertas de livros disponíveis.</p>
        @else
        @foreach($alertas as $alerta)
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            <div>
                📖 O livro <strong>{{ $alerta->livro->nome }}</strong> já está disponível!
            </div>
            <a href="{{ route('livros.show', $alerta->livro->id) }}" class="btn btn-sm btn-primary">Ver</a>
        </div>
        @endforeach
        @endif


    </div>
</x-app-layout>
