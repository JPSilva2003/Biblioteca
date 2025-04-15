<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;


class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'requisicao.livro'])->orderBy('created_at', 'desc')->get();
        return view('admin.reviews.index', compact('reviews'));
    }


    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    public function alterarEstado(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:ativo,recusado',
            'justificacao' => 'nullable|string'
        ]);

        $review->estado = $request->estado;
        $review->justificacao = $request->justificacao;
        $review->save();

        // Notificar cidadão
        $review->user->notify(new \App\Notifications\ReviewAtualizado($review));

        return redirect()->route('admin.reviews.index')->with('success', 'Estado atualizado!');
    }

}
