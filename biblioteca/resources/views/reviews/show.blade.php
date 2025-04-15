<x-app-layout>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">🔍 Detalhe da Review</h2>

        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">📖 Livro: {{ $review->requisicao->livro->nome }}</h4>
                <p><strong>👤 Utilizador:</strong> {{ $review->user->name }}</p>
                <p><strong>🗓️ Criado em:</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>💬 Conteúdo:</strong></p>
                <div class="border p-3 rounded bg-light">
                    {{ $review->conteudo }}
                </div>
                <p class="mt-3"><strong>📌 Estado:</strong>
                    <span class="badge
                        @if($review->estado == 'ativo') bg-success
                        @elseif($review->estado == 'suspenso') bg-warning
                        @else bg-danger @endif">
                        {{ ucfirst($review->estado) }}
                    </span>
                </p>

                @if($review->estado == 'recusado' && $review->justificacao)
                <p class="text-danger mt-2"><strong>Justificação:</strong> {{ $review->justificacao }}</p>
                @endif
            </div>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3 d-block text-center">⬅ Voltar</a>
    </div>
</x-app-layout>
