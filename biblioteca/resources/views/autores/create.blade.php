<x-app-layout>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="width: 50%; max-width: 600px;">
        <div class="card-header bg-primary text-white text-center fw-bold">
            ✏ Adicionar Autor
        </div>
        <div class="card-body center-table">
            <form action="{{ route('autores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">✍ Nome do Autor</label>
                    <input type="text" name="nome" class="form-control text-center" required>
                </div>

                <div class="text-center">
                    <label class="form-label fw-bold">🖼 Foto do Autor</label>
                    <input type="file" name="foto" class="form-control text-center" accept="image/*" required>
                </div>

                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('autores.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Adicionar Autor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .center-table {
        width: 100%;
        margin: auto;
        font-size: 1.1rem;
    }
</style>
</x-app-layout>
