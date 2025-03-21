<x-app-layout>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary fw-bold">🏢 Adicionar Nova Editora</h1>
        <a href="{{ route('editoras.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form-container">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <form action="{{ route('editoras.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">🏢 Nome da Editora</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">🖼 Logo da Editora</label>
                        <input type="file" name="logo" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Salvar Editora
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
        max-width: 600px;
    }
</style>
</x-app-layout>
