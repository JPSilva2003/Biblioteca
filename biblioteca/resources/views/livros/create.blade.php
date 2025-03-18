@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary fw-bold">📚 Adicionar Novo Livro</h1>
        <a href="{{ route('livros') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card shadow-lg w-50">
            <div class="card-body">
                <form action="{{ route('livros.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">📖 ISBN</label>
                        <input type="text" name="isbn" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">📌 Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">🏢 Editora</label>
                        <select name="editora_id" class="form-control" required>
                            @foreach($editoras as $editora)
                            <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">💲 Preço</label>
                        <input type="text" name="preco" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Salvar Livro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
