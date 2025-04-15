<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage; // opcional, caso uses email
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ReviewAtualizado extends Notification
{
    use Queueable;

    protected $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function via($notifiable)
    {
        // Vamos usar apenas a base de dados (notificações internas)
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'mensagem' => $this->gerarMensagem(),
            'review_id' => $this->review->id,
            'estado' => $this->review->estado,
        ];
    }

    private function gerarMensagem()
    {
        if ($this->review->estado === 'ativo') {
            return 'O seu review foi aprovado e está agora visível para outros utilizadores.';
        }

        if ($this->review->estado === 'recusado') {
            return 'O seu review foi recusado. Justificação: ' . $this->review->justificacao;
        }

        return 'O estado do seu review foi atualizado.';
    }
}
