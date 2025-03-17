@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Livros</h1>
    <a href="{{ route('livros.create') }}" class="btn btn-primary">Novo Livro</a>

    <table class="table">
        <tr>
            <th>ISBN</th>
            <th>Nome</th>
            <th>Editora</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
        @foreach($livros as $livro)
        <tr>
            <td>{{ $livro->isbn }}</td>
            <td>{{ $livro->nome }}</td>
            <td>{{ $livro->editora->nome }}</td>
            <td>R$ {{ number_format($livro->preco, 2, ',', '.') }}</td>
            <td>
                <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('livros.destroy', $livro->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
