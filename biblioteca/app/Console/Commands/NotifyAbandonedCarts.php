<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CartItem;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class NotifyAbandonedCarts extends Command
{
    protected $signature = 'notify:abandoned-carts';
    protected $description = 'Envia e-mails para carrinhos abandonados há mais de 1 hora';

    public function handle()
    {
        $oneHourAgo = Carbon::now()->subHour(); // Para produção (1 hora)
        //$oneHourAgo = Carbon::now()->subMinutes(1); // Para testar rápido (1 minuto)

        // Busca carrinhos criados há mais de 1 hora e não finalizados
        $abandonedCarts = CartItem::where('created_at', '<', $oneHourAgo)->get();

        foreach ($abandonedCarts as $cart) {
            $user = $cart->user; // Busca o dono do carrinho

            if ($user && $user->email) {
                Mail::raw("Olá {$user->name}, seu carrinho está abandonado! Precisa de ajuda?", function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Seu carrinho está te esperando!');
                });
            }
        }

        $this->info('E-mails de carrinho abandonado enviados com sucesso!');
    }
}
