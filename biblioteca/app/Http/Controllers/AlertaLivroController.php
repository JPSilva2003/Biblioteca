<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertaLivro;
use Illuminate\Support\Facades\Auth;

class AlertaLivroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id',
        ]);

        // Evitar duplicação
        $existe = AlertaLivro::where('livro_id', $request->livro_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$existe) {
            AlertaLivro::create([
                'livro_id' => $request->livro_id,
                'user_id' => Auth::id(),
                'notificado' => false,
            ]);
        }

        return back()->with('success', 'Serás notificado quando este livro estiver disponível.');
    }

    /**
     * Marca todos os alertas do livro como notificados.
     */
    public static function notificarUsuarios($livro_id)
    {
        $alertas = AlertaLivro::where('livro_id', $livro_id)
            ->where('notificado', false)
            ->get();

        foreach ($alertas as $alerta) {
            $alerta->notificado = true;
            $alerta->save();
        }
    }


}
