<x-app-layout>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary fw-bold">✏ Editar Livro</h1>
        <a href="{{ route('livros') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form-container">
        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('livros.update', $livro->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">📖 ISBN</label>
                            <input type="text" name="isbn" class="form-control text-center" value="{{ $livro->isbn }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">📌 Nome</label>
                            <input type="text" name="nome" class="form-control text-center" value="{{ $livro->nome }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">✍ Autor</label>
                            <input type="text" name="autores" class="form-control text-center" value="{{ $livro->autores }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">🏢 Editora</label>
                            <select name="editora_id" class="form-control text-center" required>
                                @foreach($editoras as $editora)
                                <option value="{{ $editora->id }}" {{ $livro->editora_id == $editora->id ? 'selected' : '' }}>
                                    {{ $editora->nome }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">📜 Bibliografia</label>
                        <textarea name="bibliografia" class="form-control text-center" rows="3" required>{{ $livro->bibliografia }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">💲 Preço</label>
                            <input type="text" name="preco" class="form-control text-center" value="{{ $livro->preco }}" required>
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-bold">🖼 Capa do Livro</label>
                            @if($livro->imagem_capa)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$livro->imagem_capa) }}" alt="Capa do Livro" class="img-thumbnail shadow-lg" width="100">
                            </div>
                            @endif
                            <input type="file" name="imagem_capa" class="form-control">
                        </div>
                    </div>

                    <!-- Botões mais estilosos -->
                    <div class="d-flex justify-content-center gap-3 mt-4">

                        <button type="submit" class="btn btn-success d-flex align-items-center px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Atualizar Livro
                        </button>

                        <a href="{{ route('livros') }}" class="btn btn-danger d-flex align-items-center px-4 py-2 shadow-sm">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>

                    </div>
                    <a href="{{ route('livros.export', $livro->id) }}" class="btn btn-primary">
                        <i class="fas fa-file-export"></i> Exportar Dados
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .img-thumbnail {
        border-radius: 5px;
    }
    .btn {
        font-size: 1rem;
        border-radius: 8px;
        transition: 0.3s ease-in-out;
    }
    .btn:hover {
        transform: scale(1.05);
    }
</style>
</x-app-layout>
