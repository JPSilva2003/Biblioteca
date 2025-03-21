<x-app-layout>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0 text-primary fw-bold">📚 Adicionar Novo Livro</h1>
            <a href="{{ route('livros') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="form-container">
            <div class="card shadow-lg p-4">
                <div class="card-body">
                    <form action="{{ route('livros.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">📖 ISBN</label>
                            <input type="text" name="isbn" class="form-control input-custom" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">📌 Nome</label>
                            <input type="text" name="nome" class="form-control input-custom" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">✍ Autor</label>
                            <input type="text" name="autores" class="form-control input-custom" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">📜 Bibliografia</label>
                            <textarea name="bibliografia" class="form-control input-custom" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">🏢 Editora</label>
                            <select name="editora_id" class="form-select input-custom" required>
                                @foreach($editoras as $editora)
                                <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">💲 Preço</label>
                            <input type="text" name="preco" class="form-control input-custom" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">🖼 Capa do Livro</label>
                            <input type="file" name="imagem_capa" class="form-control input-custom">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg btn-custom">
                                <i class="fas fa-save"></i> Salvar Livro
                            </button>
                        </div>
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
            width: 100%;
            margin: auto;
            max-width: 550px;
        }

        .card {
            border-radius: 15px;
            border: none;
        }

        .input-custom {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            transition: all 0.3s ease-in-out;
        }

        .input-custom:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-custom {
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #007bff;
            transform: scale(1.05);
        }
    </style>
</x-app-layout>
