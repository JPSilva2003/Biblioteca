<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NotificacaoPersonalizada extends Notification
{
    use Queueable;

    protected $titulo;
    protected $mensagem;
    protected $link;

    public function __construct($titulo, $mensagem, $link)
    {
        $this->data = [
            'titulo' => $titulo,
            'mensagem' => $mensagem,
            'link' => $link,
        ];
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'titulo' => $this->titulo,
            'mensagem' => $this->mensagem,
            'link' => $this->link,
        ];
    }
}
