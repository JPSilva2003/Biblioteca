<x-app-layout>
    <div class="container mt-5">
        <h2 class="mb-4">🔔 Notificações</h2>

        @forelse(auth()->user()->notifications as $notificacao)
        <div class="alert alert-info">
            <strong>{{ $notificacao->data['titulo'] }}</strong><br>
            {{ $notificacao->data['mensagem'] }}<br>
            <small>{{ $notificacao->created_at->diffForHumans() }}</small>
        </div>
        @empty
        <p>Sem notificações.</p>
        @endforelse
    </div>
</x-app-layout>
