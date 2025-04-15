<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisicao;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequisicaoCriada;
use App\Mail\RequisicaoConfirmada;

class RequisicaoController extends Controller
{
    /**
     * Lista todas as requisições.
     */
    public function index()
    {
        $requisicoes = Requisicao::with('livro', 'user')->get();

        return view('requisicoes.index', [
            'requisicoes' => $requisicoes,
            'requisicoesAtivas' => Requisicao::where('status', 'Ativa')->count(),
            'requisicoesUltimos30Dias' => Requisicao::where('data_requisicao', '>=', now()->subDays(30))->count(),
            'livrosEntreguesHoje' => Requisicao::whereDate('data_requisicao', now())->where('status', 'Concluída')->count(),
        ]);
    }
    /**
     * Mostra o formulário de criação de requisição.
     */
    public function create()
    {
        $livros = Livro::where('disponivel', true)->get();

        return view('requisicoes.create', compact('livros'));
    }

    /**
     * Salva uma nova requisição.
     */
    public function store(Request $request)
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id',
        ]);

            $user = Auth::user();
        $livro = Livro::findOrFail($request->livro_id);

        // Verifica se o cidadão já tem 3 livros requisitados ativos
        $requisicoesAtivas = Requisicao::where('user_id', $user->id)
            ->where('status', 'Ativa')
            ->count();

        if ($requisicoesAtivas >= 3) {
            return redirect()->back()->with('error', 'Você já atingiu o limite de 3 livros requisitados.');
        }

        // Verifica se o livro ainda está disponível antes de requisitar
        if (!$livro->disponivel) {
            return redirect()->back()->with('error', 'Este livro já foi requisitado e está indisponível.');
        }

        // Criar número sequencial da requisição
        $ultimoNumero = Requisicao::max('id') ?? 0;
        $numeroRequisicao = str_pad($ultimoNumero + 1, 5, '0', STR_PAD_LEFT);


        // Criar a requisição com data de devolução 5 dias após a requisição
        $requisicao = new Requisicao();
        $requisicao->user_id = $user->id;
        $requisicao->livro_id = $request->livro_id;
        $requisicao->data_requisicao = now();
        $requisicao->data_prevista_entrega = now()->addDays(5);
        $requisicao->status = 'Ativa';
        $requisicao->save();

        // Marcar livro como indisponível
        $livro->disponivel = false;
        $livro->save();



        // Enviar e-mail para o usuário logado
        Mail::to(auth()->user()->email)->send(new RequisicaoConfirmada($requisicao));

        // Enviar e-mail para os administradores
        Mail::to('jpedro.p.silva2003@gmail.com')->send(new RequisicaoConfirmada($requisicao));


        // Enviar e-mail para Admin e Cidadão
        $admins = User::where('role_id', true)->pluck('email');
        Mail::to($user->email)->cc($admins)->send(new RequisicaoCriada($requisicao));


        return redirect()->route('requisicoes.index')->with('success', 'Requisição realizada com sucesso!');
    }



    /**
     * Exibe os detalhes de uma requisição.
     */
    public function show($id)
    {
        $requisicao = Requisicao::with('livro', 'user')->findOrFail($id);

        return view('requisicoes.show', compact('requisicao'));
    }

    /**
     * Confirma a entrega de um livro.
     */
    public function confirmarRecebimento($id)
    {
        $requisicao = Requisicao::findOrFail($id);
        $requisicao->update(['status' => 'Concluída']);

        //Tornar o livro disponível novamente
        $livro = Livro::find($requisicao->livro_id);
        if ($livro) {
            $livro->disponivel = true;
            $livro->save();

            // ✅ Notificar utilizadores que pediram alerta
            \App\Http\Controllers\AlertaLivroController::notificarUsuarios($livro->id);
        }





        return redirect()->route('requisicoes.index')->with('success', 'Requisição concluída e livro disponível novamente.');
    }


    /**
     * Remove uma requisição.
     */
    public function destroy($id)
    {
        $requisicao = Requisicao::findOrFail($id);

        // Atualiza o livro para disponível novamente
        $livro = Livro::find($requisicao->livro_id);
        if ($livro) {
            $livro->disponivel = true;
            $livro->save();
        }

        // Remove a requisição
        $requisicao->delete();

        return redirect()->route('requisicoes.index')->with('success', 'Requisição removida e livro disponível novamente.');
    }

    public function devolver($id)
    {
        $requisicao = Requisicao::findOrFail($id);
        $livro = $requisicao->livro;

        $requisicao->status = 'Concluída';
        $requisicao->data_devolucao = now();
        $requisicao->save();

        $livro->disponivel = true;
        $livro->save();

        // ✅ Notificar quem pediu alerta
        \App\Http\Controllers\AlertaLivroController::notificarUsuarios($livro->id);

        return redirect()->back()->with('success', 'Livro devolvido com sucesso.');
    }




    public function concluirRequisicao($id)
    {
        $requisicao = Requisicao::findOrFail($id);
        $requisicao->status = 'Concluída';
        $requisicao->save();

        // Tornar o livro disponível novamente após a entrega
        $livro = Livro::find($requisicao->livro_id);
        if ($livro) {
            $livro->disponivel = true;
            $livro->save();

            // ✅ Notificar quem está à espera
            \App\Http\Controllers\AlertaLivroController::notificarUsuarios($livro->id);
        }

        return redirect()->route('requisicoes.index')->with('success', 'Requisição concluída e livro disponível novamente.');
    }

}
