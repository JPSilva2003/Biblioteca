<?php

namespace App\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define os comandos Artisan a serem agendados.
     */
    protected function schedule(Schedule $schedule)
    {
        // Agendar a verificação de carrinhos abandonados a cada minuto (para testar)
        $schedule->command('notify:abandoned-carts')->everyMinute();
    }

    /**
     * Registra os comandos do aplicativo.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
