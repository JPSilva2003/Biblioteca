<x-app-layout>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary fw-bold">🏢 Editar Editora</h1>
        <a href="{{ route('editoras.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form-container">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <form action="{{ route('editoras.update', $editora->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">🏢 Nome da Editora</label>
                        <input type="text" name="nome" class="form-control" value="{{ $editora->nome }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">🖼 Logo da Editora</label>
                        <input type="file" name="logo" class="form-control">
                        @if($editora->logo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$editora->logo) }}" alt="Logo Atual" class="logo-editora">
                        </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Atualizar Editora
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

    .logo-editora {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }
</style>
</x-app-layout>
