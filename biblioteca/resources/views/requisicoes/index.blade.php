<x-app-layout>
    <div class="container py-5">
        <h2 class="mb-4 fw-bold text-primary">📚 Lista de Requisições</h2>

        <!-- Indicadores -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-info text-dark">
                    <div class="card-body text-left">
                        <h5 class="fw-semibold">📌 Requisições Ativas</h5>
                        <h2 class="fw-bold">{{ $requisicoesAtivas ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-success text-dark">
                    <div class="card-body text-left">
                        <h5 class="fw-semibold">📅 Últimos 30 dias</h5>
                        <h2 class="fw-bold">{{ $requisicoesUltimos30Dias ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-warning text-dark">
                    <div class="card-body text-left">
                        <h5 class="fw-semibold">📖 Livros Entregues Hoje</h5>
                        <h2 class="fw-bold">{{ $livrosEntreguesHoje ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                        <tr class="text-uppercase text-muted small">
                            <th class="p-3">#</th>
                            <th class="p-3">📖 Livro</th>
                            <th class="p-3">👤 Utilizador</th>
                            <th class="p-3">📆 Requisição</th>
                            <th class="p-3">📅 Entrega Prevista</th>
                            <th class="p-3">📌 Status</th>
                            <th class="p-3">⚙ Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($requisicoes as $req)
                        @if(auth()->user()->role_id == 1 || auth()->user()->id == $req->user_id)
                        <tr>
                            <td class="fw-bold p-3">{{ $req->id }}</td>
                            <td class="p-3">{{ $req->livro->nome }}</td>
                            <td class="p-3">{{ $req->user->name }}</td>
                            <td class="p-3">{{ $req->data_requisicao }}</td>
                            <td class="p-3">{{ $req->data_prevista_entrega }}</td>
                            <td class="p-3">
                                        <span class="badge status-{{ $req->status }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                            </td>
                            <td class="p-3">
                                <a href="{{ route('requisicoes.show', $req->id) }}" class="btn btn-info btn-sm">
                                    🔍 Detalhes
                                </a>
                                @if(auth()->user()->role_id == 1)
                                <form action="{{ route('requisicoes.destroy', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja remover esta requisição?')">
                                        🗑 Remover
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Botão de Voltar -->
        <div class="text-end mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                ⬅️ Voltar ao Painel
            </a>
        </div>
    </div>

    <!-- Estilos personalizados -->
    <style>
        .badge {
            font-size: 1rem;
            padding: 0.5em 1.2em;
            border-radius: 12px;
            font-weight: 600;
        }


        table td, table th {
            vertical-align: middle;
            padding: 1rem !important;
        }

        .table thead th {
            background-color: #c5c4c4;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn-info {
            background-color: #f1f1f1;
            border-color: #f1f1f1;
        }

        .btn-danger {
            background-color: #f1f1f1;
            border-color: #f1f1f1;
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
    </style>
</x-app-layout>
