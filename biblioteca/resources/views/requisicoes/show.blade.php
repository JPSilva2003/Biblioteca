<x-app-layout>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">📄 Detalhes da Requisição</h2>

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h4 class="card-title">📖 Livro: <strong>{{ $requisicao->livro->nome }}</strong></h4>
                <p><strong>👤 Utilizador:</strong> {{ $requisicao->user->name }}</p>
                <p><strong>📆 Data da Requisição:</strong> {{ $requisicao->data_requisicao }}</p>
                <p><strong>📅 Data Prevista de Entrega:</strong> {{ $requisicao->data_prevista_entrega }}</p>
                <p><strong>📌 Status:</strong>
                    <span class="badge {{ $requisicao->status == 'pendente' ? 'bg-warning' : 'bg-success' }}">
                        {{ ucfirst($requisicao->status) }}
                    </span>
                </p>

                {{-- Mostrar botão de confirmação apenas se for Admin e o status não for concluída --}}
                @if(auth()->user()->role_id == 1 && $requisicao->status !== 'Concluída')
                <form action="{{ route('requisicoes.confirmarRecebimento', $requisicao->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success btn-lg w-100" onclick="return confirm('Confirmar recebimento? O livro será liberado novamente.')">
                        ✅ Confirmar Recebimento e Liberar Livro
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Se o user for o dono, a requisição estiver concluída e ainda não existir review --}}
        @if(auth()->id() === $requisicao->user_id && $requisicao->status === 'Concluída' && !$requisicao->review)
        <div class="card mt-4 shadow border-0">
            <div class="card-body">
                <h5 class="card-title">✍️ Deixe o seu Review</h5>

                <form action="{{ route('reviews.store', ['id' => $requisicao->id]) }}" method="POST">
                @csrf
                    <input type="hidden" name="requisicao_id" value="{{ $requisicao->id }}">

                    <div class="mb-3">
                        <label for="conteudo" class="form-label">Comentário:</label>
                        <textarea name="conteudo" id="conteudo" class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">💬 Enviar Review</button>
                </form>
            </div>
        </div>
        @endif

        {{-- Mostrar review existente, se houver --}}
        @if($requisicao->review)
        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">📢 O seu Review</h5>
                <p><strong>Estado:</strong>
                    <span class="badge
                            @if($requisicao->review->estado == 'ativo') bg-success
                            @elseif($requisicao->review->estado == 'recusado') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($requisicao->review->estado) }}
                        </span>
                </p>
                <p>{{ $requisicao->review->conteudo }}</p>

                @if($requisicao->review->estado === 'recusado')
                <p><strong>Justificação da recusa:</strong> {{ $requisicao->review->justificacao }}</p>
                @endif
            </div>
        </div>
        @endif

        <a href="{{ route('requisicoes.index') }}" class="btn btn-secondary mt-4 d-block text-center">⬅ Voltar</a>
    </div>
</x-app-layout>
