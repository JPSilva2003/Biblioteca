<x-app-layout>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0 text-primary fw-bold">📚 Livros</h1>

            @if(Auth::user()->role_id == 1) <!-- Apenas Administradores podem adicionar livros -->
            <a href="{{ route('livros.create') }}" class="btn btn-success btn-lg">
                <i class="fas fa-plus"></i> Novo Livro
            </a>
            @endif
        </div>

        <!-- Barra de Pesquisa e Filtros -->
        <form method="GET" action="{{ route('livros') }}" class="mb-4">
            <div class="d-flex justify-content-center gap-3">
                <input type="text" name="search" class="form-control shadow-sm w-50"
                       placeholder="🔍 Pesquisar por nome..." value="{{ request('search') }}">
                <select name="editora_id" class="form-select shadow-sm w-25" onchange="this.form.submit()">
                    <option value="">🏢 Todas as Editoras</option>
                    @foreach($editoras as $editora)
                    <option value="{{ $editora->id }}" {{ request('editora_id') == $editora->id ? 'selected' : '' }}>
                    {{ $editora->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="table-container">
            <div class="card shadow-lg p-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle text-center center-table">
                            <thead class="table-dark">
                            <tr>
                                <th>📖 ISBN</th>
                                <th>📌 Nome</th>
                                <th>✍ Autor</th>
                                <th>🏢 Editora</th>
                                <th>📜 Bibliografia</th>
                                <th>🖼 Capa</th>
                                <th>💲 Preço</th>
                                <th>✅ Disponibilidade</th>
                                <th>⚙ Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($livros as $livro)
                            <tr>
                                <td class="fw-bold">{{ $livro->isbn }}</td>
                                <td>{{ $livro->nome }}</td>
                                <td>{{ $livro->autores ?? 'Desconhecido' }}</td>
                                <td>{{ $livro->editora->nome ?? 'Sem Editora' }}</td>
                                <td>{{ Str::limit($livro->bibliografia, 50) }}</td>
                                <td>
                                    @if($livro->imagem_capa)
                                    <img src="{{ asset('storage/'.$livro->imagem_capa) }}" alt="Capa do Livro" class="capa-livro">
                                    @else
                                    <span class="text-muted">Sem imagem</span>
                                    @endif
                                </td>
                                <td class="text-success fw-bold">EUR€ {{ number_format($livro->preco, 2, ',', '.') }}</td>

                                <!-- Disponibilidade -->
                                <td>
                                    @if($livro->disponivel)
                                    <span class="badge bg-success p-2">Disponível</span>
                                    @else
                                    <span class="badge bg-danger p-2">Indisponível</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-info btn-sm btn-action">
                                            <i class="fas fa-info-circle"></i> Detalhes
                                        </a>

                                        @if($livro->disponivel && Auth::user()->requisicoes()->count() < 3)
                                        <a href="{{ route('requisicoes.create', $livro->id) }}" class="btn btn-primary btn-sm btn-action">
                                            <i class="fas fa-book-reader"></i> Requisitar Livro
                                        </a>
                                        @endif

                                        @if(Auth::user()->role_id == 1) <!-- Apenas Administradores podem Editar e Remover -->
                                        <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-warning btn-sm btn-action">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este livro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-action">
                                                <i class="fas fa-trash-alt"></i> Remover
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $livros->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .center-table {
            width: 100%;
            margin: auto;
            font-size: 1.1rem;
        }

        .capa-livro {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .capa-livro:hover {
            transform: scale(1.1);
        }

        .btn-action {
            transition: all 0.3s ease-in-out;
        }

        .btn-action:hover {
            transform: scale(1.05);
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
            border-radius: 8px;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: white;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: white;
        }
    </style>
</x-app-layout>
