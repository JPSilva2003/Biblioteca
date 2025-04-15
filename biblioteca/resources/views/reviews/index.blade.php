@extends('layouts.admin')

@section('title', 'Gestão de Reviews')

@section('content')
<h1>Reviews Submetidas</h1>

@if($reviews->isEmpty())
<p>Não existem reviews pendentes.</p>
@else
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Utilizador</th>
        <th>Requisição</th>
        <th>Estado</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reviews as $review)
    <tr>
        <td>{{ $review->id }}</td>
        <td>{{ $review->user->name }}</td>
        <td>#{{ $review->requisicao->id }}</td>
        <td>
                            <span class="badge bg-{{ $review->estado === 'ativo' ? 'success' : ($review->estado === 'recusado' ? 'danger' : 'warning') }}">
                                {{ ucfirst($review->estado) }}
                            </span>
        </td>
        <td>{{ $review->created_at->format('d/m/Y') }}</td>
        <td>
            <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-sm btn-primary">Ver</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif
@endsection
