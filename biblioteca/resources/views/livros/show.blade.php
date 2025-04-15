<x-app-layout>
    <div class="container">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <div class="row">
                    <!-- Capa do Livro -->
                    <div class="col-md-4 text-center">
                        <img src="{{ asset('storage/'.$livro->imagem_capa) }}" alt="Capa do Livro" class="capa-detalhe">
                    </div>

                    <!-- Informações do Livro -->
                    <div class="col-md-8">
                        <h1 class="fw-bold text-primary">{{ $livro->nome }}</h1>
                        <p class="text-muted">📖 ISBN: <strong>{{ $livro->isbn }}</strong></p>
                        <p>✍ <strong>Autor:</strong> {{ $livro->autores ?? 'Desconhecido' }}</p>
                        <p>🏢 <strong>Editora:</strong> {{ $livro->editora->nome ?? 'Sem Editora' }}</p>
                        <p>📜 <strong>Bibliografia:</strong> {{ $livro->bibliografia }}</p>
                        <p class="text-success fw-bold">💲 <strong>Preço:</strong> EUR€ {{ number_format($livro->preco, 2, ',', '.') }}</p>

                        <!-- Disponibilidade -->
                        <p>
                            ✅ <strong>Disponibilidade:</strong>
                            @if($livro->disponivel)
                            <span class="badge bg-success p-2">Disponível</span>
                            @else
                            <span class="badge bg-danger p-2">Indisponível</span>
                            @endif
                        </p>

                        @if($livro->disponivel && Auth::user()->requisicoes()->whereNull('data_prevista_entrega')->count() < 3)
                        <a href="{{ route('requisicoes.create', $livro->id) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-book-reader"></i> Requisitar Livro
                        </a>
                        @elseif(!$livro->disponivel)
                        @if(!$livro->alertas->where('user_id', auth()->id())->count())
                        <form action="{{ route('alertas.store') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                            <button type="submit" class="btn btn-outline-warning">
                                🔔 Avisar-me quando estiver disponível
                            </button>
                        </form>
                        @else
                        <p class="text-warning mt-3">
                            🔔 Já estás inscrito para receber notificação quando este livro estiver disponível.
                        </p>
                        @endif
                        @endif

                    </div>

                </div>






                <form action="{{ route('cart.add', $livro->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        🛒 Adicionar ao Carrinho
                    </button>
                </form>
            <br>

                <!-- Histórico de Requisições -->
                <hr class="my-4">
                <h3 class="text-secondary">📋 Histórico de Requisições</h3>

                @if($requisicoes->isEmpty())
                <p class="text-muted">Nenhuma requisição encontrada para este livro.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>📅 Data da Requisição</th>
                            <th>📆 Data Prevista de Devolução</th>
                            <th>📌 Status</th>
                            @if(auth()->user()->role_id == 1)
                            <th>👤 Utilizador</th> <!-- Apenas o admin verá esta coluna -->
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requisicoes as $requisicao)
                        @if(auth()->user()->role_id == 1 || auth()->user()->id === $requisicao->user_id)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($requisicao->data_devolucao)->format('d/m/Y') }}</td>
                            <td>
                                @if($requisicao->status == 'Ativa')
                                <span class="badge bg-primary">Pendente</span>
                                @elseif($requisicao->status == 'Concluída')
                                <span class="badge bg-success">Concluída</span>
                                @else
                                <span class="badge bg-danger">Cancelada</span>
                                @endif
                            </td>
                            @if(auth()->user()->role_id == 1)
                            <td>{{ $requisicao->user->name }}</td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif


                <!-- Livros Relacionados -->
                @if($relacionados->count())
                <hr class="my-4">
                <h3 class="text-secondary">📚 Livros Relacionados</h3>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    @foreach($relacionados as $rel)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('storage/' . $rel->imagem_capa) }}" class="card-img-top" alt="Capa do Livro">
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-truncate">{{ $rel->nome }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($rel->bibliografia, 80) }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <a href="{{ route('livros.show', $rel->id) }}" class="btn btn-outline-primary btn-sm">
                                    👁️ Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif


                <hr class="my-4">
                <h3 class="text-secondary">⭐ Opiniões de Leitores</h3>

                @if($reviews->isEmpty())
                <p class="text-muted">Ainda não existem reviews aprovadas para este livro.</p>
                @else
                @foreach($reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="mb-1"><strong>👤Utilizador: {{ $review->user->name }}</strong></p>
                        <p class="text-muted fst-italic"><strong>Data da Review:</strong> {{ $review->created_at->format('d/m/Y') }}</p>
                        <p><strong>Review:</strong> {{ $review->conteudo }}</p>
                    </div>
                </div>
                @endforeach
                @endif






                <!-- Botão Voltar -->
                <a href="{{ route('livros') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <style>
        .capa-detalhe {
            width: 100%;
            max-width: 300px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .capa-detalhe:hover {
            transform: scale(1.1);
        }

        .badge {
            font-size: 1rem;
            padding: 0.5em 0.75em;
            border-radius: 8px;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: white;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: white;
        }

        .bg-primary {
            background-color: #007bff !important;
            color: white;
        }

        .text-warning {
            color: #ffc107;
        }
    </style>
</x-app-layout>
