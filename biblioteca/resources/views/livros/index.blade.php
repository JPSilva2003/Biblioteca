@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary fw-bold">📚 Livros</h1>
        <a href="{{ route('livros.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Novo Livro
        </a>
    </div>

    <div class="table-container">
        <div class="card shadow-lg">
            <div class="card-body">
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
                        <th>⚙ Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($livros as $livro)
                    <tr>
                        <td class="fw-bold">{{ $livro->isbn }}</td>
                        <td>{{ $livro->nome }}</td>
                        <td>{{ $livro->autores }}</td>
                        <td>{{ $livro->editora->nome }}</td>
                        <td>{{ Str::limit($livro->bibliografia, 50) }}</td>
                        <td>
                            @if($livro->imagem_capa)
                            <img src="{{ asset('storage/'.$livro->imagem_capa) }}" alt="Capa do Livro" width="50">
                            @else
                            <span class="text-muted">Sem imagem</span>
                            @endif
                        </td>
                        <td class="text-success fw-bold">EUR€ {{ number_format($livro->preco, 2, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este livro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
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
        </div>
    </div>
</div>

<style>
    .table-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .center-table {
        width: 100%;
        margin: auto;
    }
    img {
        border-radius: 5px;
    }
</style>
@endsection
