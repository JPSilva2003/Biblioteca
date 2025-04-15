<x-app-layout>
    <div class="container py-5">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-5">
                <h1 class="fw-bold text-primary mb-4">📦 Lista de Encomendas</h1>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                        <tr class="text-uppercase text-muted small">
                            <th class="p-3">#</th>
                            <th class="p-3">👤 Cidadão</th>
                            <th class="p-3">💰 Total</th>
                            <th class="p-3">📅 Data</th>
                            <th class="p-3">📌 Status</th>
                            <th class="p-3">📍 Morada</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="fw-semibold p-3">{{ $order->id }}</td>
                            <td class="p-3">{{ $order->user->name }}</td>
                            <td class="text-success fw-bold p-3">€ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td class="p-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-3">
                                @if($order->status == 'pendente')
                                <span class="badge status-pendente">
                                            ⏳ Pendente
                                        </span>
                                @else
                                <span class="badge status-pago">
                                            ✅ Pago
                                        </span>
                                @endif
                            </td>
                            <td class="p-3">{{ $order->address ?? 'N/A' }}</td>
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
            font-size: 1rem;
            padding: 0.6em 1.2em;
            border-radius: 12px;
            font-weight: 600;
        }

        .status-pendente {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .status-pago {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        table td, table th {
            vertical-align: middle;
            padding: 1rem !important;
        }

        .table thead th {
            background-color: #f8f9fa;
        }
    </style>
</x-app-layout>
