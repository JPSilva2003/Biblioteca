<x-app-layout>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary fw-bold">✍ Autores</h1>
        <a href="{{ route('autores.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Novo Autor
        </a>
    </div>

    <div class="row">
        @foreach($autores as $autor)
        <div class="col-md-4">
            <div class="card shadow-lg mb-4 text-center">
                <div class="card-body">
                    <div class="author-image mb-3">
                        @if($autor->foto)
                        <img src="{{ asset('storage/'.$autor->foto) }}" alt="{{ $autor->nome }}" class="img-fluid rounded-circle shadow">
                        @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Sem Foto" class="img-fluid rounded-circle shadow">
                        @endif
                    </div>
                    <h4 class="fw-bold">{{ $autor->nome }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .author-image img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 3px solid #ddd;
    }
</style>
</x-app-layout>
