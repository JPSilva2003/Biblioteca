
@component('mail::message')
# Confirmação de Requisição de Livro 📚

Olá, **{{ $user }}**!

A sua requisição de livro foi realizada com sucesso. Aqui estão os detalhes:

📖 **Livro:** {{ $livro }}
📅 **Data da Requisição:** {{ $data_requisicao }}
📅 **Data Prevista para Entrega:** {{ $data_prevista_entrega }}

@if($capa_livro)
![Capa do Livro]({{ $capa_livro }})
@endif

Aguarde a confirmação da biblioteca para a retirada do livro.

Obrigado por usar nossos serviços!
Biblioteca Municipal 📚
@endcomponent
