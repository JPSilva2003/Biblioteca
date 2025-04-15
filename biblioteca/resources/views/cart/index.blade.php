<x-app-layout>
    <div class="container py-5">
        <div class="card shadow-lg p-5 border-0 rounded-4">
            <h1 class="fw-bold text-primary mb-4">🛒 Seu Carrinho</h1>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($cartItems->isEmpty())
            <div class="text-center text-muted fs-5">Seu carrinho está vazio.</div>
            @else
            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                    <tr>
                        <th>📚 Livro</th>
                        <th>🔢 Quantidade</th>
                        <th>⚙️ Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->livro->nome }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Deseja remover este item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    ❌ Remover
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <form action="{{ route('checkout.index') }}" method="GET" class="border-top pt-4">
                @csrf
                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">📍 Morada de Entrega</label>
                    <input type="text" name="address" id="address" class="form-control rounded-3 shadow-sm" placeholder="Rua, número, cidade..." required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        💳 Finalizar Compra
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>

    <style>
        table th, table td {
            vertical-align: middle;
        }

        .btn-success {
            background-color: #198754;
            border: none;
        }


    </style>
</x-app-layout>
