<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Requisicao;

class RequisicaoCriada extends Mailable
{
    use Queueable, SerializesModels;

    public $requisicao;

    public function __construct(Requisicao $requisicao)
    {
        $this->requisicao = $requisicao;
    }

    public function build()
    {
        return $this->subject('Confirmação de Requisição de Livro')
            ->view('emails.requisicao-criada')
            ->with([
                'requisicao' => $this->requisicao,
                'livro' => $this->requisicao->livro,
                'user' => $this->requisicao->user
            ]);
    }
}
