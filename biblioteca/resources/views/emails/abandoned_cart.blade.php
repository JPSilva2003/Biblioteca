<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu carrinho está esperando!</title>
</head>
<body>
<h2>Olá, {{ $user->name }}!</h2>
<p>Notamos que você adicionou itens ao seu carrinho, mas ainda não finalizou a compra.</p>
<p>Se precisar de ajuda ou tiver dúvidas, estamos aqui para ajudar! 😊</p>
<p><a href="{{ route('cart.index') }}" style="background-color: green; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">Ir para o carrinho</a></p>
<p>Atenciosamente,<br>Equipe da Loja</p>
</body>
</html>
