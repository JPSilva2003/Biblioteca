<x-app-layout>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0 text-primary fw-bold">📚 Livros</h1>
            <a href="{{ route('livros.create') }}" class="btn btn-success btn-lg">
                <i class="fas fa-plus"></i> Novo Livro
            </a>
        </div>

        <!-- Barra de Pesquisa e Filtros -->
        <form method="GET" action="{{ route('livros') }}" class="mb-4">
            <div class="d-flex justify-content-center gap-3">

                <!-- Barra de Pesquisa -->
                <input type="text" name="search" class="form-control shadow-sm w-50"
                       placeholder="🔍 Pesquisar por nome..." value="{{ request('search') }}">

                <!-- Filtro de Editora -->
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
                                <th class="largura-coluna">📖 ISBN</th>
                                <th class="largura-coluna">📌 Nome</th>
                                <th class="largura-coluna">✍ Autor</th>
                                <th class="largura-coluna">🏢 Editora</th>
                                <th class="largura-coluna">📜 Bibliografia</th>
                                <th class="largura-coluna">🖼 Capa</th>
                                <th class="largura-coluna">💲 Preço</th>
                                <th class="largura-coluna">⚙ Ações</th>
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
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
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

        .largura-coluna {
            width: 20%;
            white-space: nowrap;
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
    </style>
</x-app-layout>
