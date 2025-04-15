<?php

namespace App\Mail;

use App\Models\Requisicao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequisicaoConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    public $requisicao;

    /**
     * Cria uma nova instância do e-mail.
     */
    public function __construct(Requisicao $requisicao)
    {
        $this->requisicao = $requisicao;
    }

    /**
     * Constrói o e-mail.
     */
    public function build()
    {
        return $this->subject('Confirmação de Requisição de Livro')
            ->markdown('emails.requisicao')
            ->with([
                'user' => $this->requisicao->user->name,
                'livro' => $this->requisicao->livro->nome,
                'data_requisicao' => $this->requisicao->data_requisicao->format('d/m/Y'),
                'data_prevista_entrega' => $this->requisicao->data_prevista_entrega->format('d/m/Y'),
                'capa_livro' => asset('storage/capas/' . $this->requisicao->livro->capa),
            ]);
    }
}
