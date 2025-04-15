<x-app-layout>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">✍️ Editar Review</h2>

        <div class="card shadow">
            <div class="card-body">
                <h5 class="mb-3">📖 Livro: {{ $review->requisicao->livro->nome ?? 'Desconhecido' }}</h5>

                <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="conteudo" class="form-label">Comentário: </label>
                        <textarea name="conteudo" id="conteudo" class="form-control" rows="4" required>{{ old('conteudo', $review->conteudo) }}</textarea>
                    </div>


                    @if(auth()->user()->role_id == 1)
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado:</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="suspenso" {{ $review->estado === 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                            <option value="ativo" {{ $review->estado === 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="recusado" {{ $review->estado === 'recusado' ? 'selected' : '' }}>Recusado</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="justificacao" class="form-label">Justificação (se recusado):</label>
                        <textarea name="justificacao" id="justificacao" class="form-control" rows="2">{{ old('justificacao', $review->justificacao) }}</textarea>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary">💾 Atualizar Review</button>
                    <a href="{{ route('reviews.index') }}" class="btn btn-secondary">⬅ Voltar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
