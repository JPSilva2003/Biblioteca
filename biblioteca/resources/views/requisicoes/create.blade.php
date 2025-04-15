<x-app-layout>
    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h2 class="mb-4 text-center">📚 Fazer uma Requisição de Livro</h2>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('requisicoes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="livro_id" class="form-label">📖 Escolha um Livro</label>
                    <select name="livro_id" id="livro_id" class="form-select" required>
                        @foreach ($livros as $livro)
                        <option value="{{ $livro->id }}">{{ $livro->nome }} (Disponível)</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">📩 Requisitar</button>
            </form>
        </div>
    </div>
</x-app-layout>
