<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Requisicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NotificacaoPersonalizada;

class ReviewController extends Controller
{
    // Cidadão cria uma nova review após entregar o livro
    public function store(Request $request, $requisicao_id)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000',
        ]);

        $requisicao = Requisicao::findOrFail($requisicao_id);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->requisicao_id = $requisicao->id;
        $review->conteudo = $request->conteudo;
        $review->estado = 'suspenso';
        $review->save();

        // 🔔 Envia notificação para o próprio cidadão
        Auth::user()->notify(new NotificacaoPersonalizada(
            'Review enviada com sucesso',
            'Clique no botão abaixo para ver a sua review.',
            route('reviews.show', $review->id)
        ));

        return redirect()->back()->with('success', 'Review enviada com sucesso e está a aguardar aprovação.');
    }

    public function userReviews()
    {
        if (auth()->user()->role_id === 1) {
            // Admin vê todas
            $reviews = \App\Models\Review::with('requisicao.livro', 'user')->latest()->get();
        } else {
            // Cidadão só vê as dele
            $reviews = \App\Models\Review::with('requisicao.livro')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('reviews.user', compact('reviews'));
    }



    public function index()
    {
        if (auth()->user()->role_id == 1) {
            // Admin vê todas
            $reviews = Review::with(['user', 'requisicao.livro'])->orderBy('created_at', 'desc')->get();
        } else {
            // Cidadão vê só as suas
            $reviews = Review::with('requisicao.livro')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        }

        return view('reviews.index', compact('reviews'));
    }
    public function edit($id)
    {
        $review = Review::with('requisicao.livro')->findOrFail($id);

        // Só o dono ou admin pode editar
        if (auth()->user()->id !== $review->user_id && auth()->user()->role_id != 1) {
            abort(403, 'Acesso negado');
        }

        return view('reviews.update', compact('review'));
    }

    // Admin edita o estado da review
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $user = auth()->user();

        if ($user->id !== $review->user_id && $user->role_id !== 1) {
            abort(403, 'Acesso negado');
        }

        // Validações diferentes para admin e cidadão
        if ($user->role_id === 1) {
            // Admin: só precisa validar estado e justificacao
            $data = $request->validate([
                'estado' => 'required|in:suspenso,ativo,recusado',
                'justificacao' => 'nullable|string|max:1000',
            ]);

            $review->estado = $data['estado'];
            $review->justificacao = $data['justificacao'] ?? null;

            // Notificar o cidadão
            $review->user->notify(new \App\Notifications\NotificacaoPersonalizada(
                'Estado da review atualizado',
                'O estado da sua review foi alterado para "' . $review->estado . '"' .
                ($review->estado === 'recusado' ? ' com justificação: ' . $review->justificacao : ''),
                route('reviews.show', $review->id)
            ));
        } else {
            // Cidadão: só pode editar o conteúdo
            $data = $request->validate([
                'conteudo' => 'required|string|max:1000',
            ]);

            $review->conteudo = $data['conteudo'];
        }

        $review->save();

        return redirect()->back()->with('success', 'Review atualizada com sucesso!');
    }



    // Ver detalhes da review
    public function show($id)
    {
        $review = Review::with('user', 'requisicao.livro')->findOrFail($id);
        return view('reviews.show', compact('review'));
    }
}
