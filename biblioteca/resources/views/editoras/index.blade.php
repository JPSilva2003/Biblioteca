<x-app-layout>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary fw-bold">🏢 Editoras</h1>
        <a href="{{ route('editoras.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Nova Editora
        </a>
    </div>

    <div class="table-container">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center center-table">
                        <thead class="table-dark">
                        <tr>
                            <th class="largura-coluna">🏢 Logo</th>
                            <th class="largura-coluna">🏢 Nome</th>
                            <th class="largura-coluna">⚙ Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($editoras as $editora)
                        <tr>
                            <td>
                                @if($editora->logo)
                                <img src="{{ asset('storage/'.$editora->logo) }}" alt="Logo da Editora" class="logo-editora">
                                @else
                                <span class="text-muted">Sem logo</span>
                                @endif
                            </td>
                            <td class="fw-bold text-primary">{{ $editora->nome }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('editoras.edit', $editora->id) }}" class="btn btn-warning btn-sm btn-action">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('editoras.destroy', $editora->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esta editora?');">
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
        width: 30%;
        white-space: nowrap;
    }

    .logo-editora {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #ddd;
        background: #fff;
    }

    .btn-action {
        transition: all 0.3s ease-in-out;
    }

    .btn-action:hover {
        transform: scale(1.05);
    }
</style>
</x-app-layout>
