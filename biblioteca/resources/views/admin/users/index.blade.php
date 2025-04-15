<x-app-layout>
    <div class="container py-5">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-5">
                <h1 class="fw-bold text-primary mb-3">👥 Gestão de Utilizadores</h1>
                <p class="text-muted mb-4">Aqui pode visualizar todos os utilizadores e gerir os seus níveis de acesso.</p>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>👤 Nome</th>
                            <th>📧 Email</th>
                            <th>🔐 Perfil</th>
                            <th>⚙️ Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role_id == 1)
                                <span class="badge bg-success">Administrador</span>
                                @else
                                <span class="badge bg-secondary">Cidadão</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->id !== $user->id)
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex justify-content-center">
                                        <select name="role_id" class="form-select w-auto" onchange="this.form.submit()">
                                            <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Administrador</option>
                                            <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Cidadão</option>
                                        </select>
                                    </div>
                                </form>
                                @else
                                <span class="text-muted">⚠️ Não pode alterar seu próprio perfil</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        ⬅️ Voltar ao Painel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge {
            font-size: 0.95rem;
            padding: 0.4em 0.7em;
            border-radius: 0.75rem;
        }

        .bg-success {
            background-color: #198754 !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        table td, table th {
            vertical-align: middle;
        }

        .form-select {
            min-width: 150px;
        }
    </style>
</x-app-layout>
