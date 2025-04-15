<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Requisição</title>
</head>
<body>
<h2>Confirmação de Requisição</h2>
<p>Olá {{ $user->name }},</p>
<p>A sua requisição foi confirmada com sucesso. Aqui estão os detalhes:</p>

<ul>
    <li><strong>Número da Requisição:</strong> #{{ $requisicao->numero }}</li>
    <li><strong>Livro:</strong> {{ $livro->nome }}</li>
    <li><strong>Data da Requisição:</strong> {{ $requisicao->data_requisicao->format('d/m/Y') }}</li>
    <li><strong>Data Prevista de Devolução:</strong> {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</li>
</ul>

<p><img src="{{ asset('storage/' . $livro->capa) }}" alt="Capa do Livro" style="max-width:200px;"></p>

<p>Obrigado por utilizar a nossa biblioteca!</p>
</body>
</html>
