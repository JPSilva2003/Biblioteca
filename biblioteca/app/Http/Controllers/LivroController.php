<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Editora;

class LivroController extends Controller
{
    public function index()
    {
        $livros = Livro::with('editora')->get();
        return view('livros.index', compact('livros'));
    }

    public function create()
    {
        $editoras = Editora::all();
        return view('livros.create', compact('editoras'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('imagem_capa')) {
            $data['imagem_capa'] = $request->file('imagem_capa')->store('capas', 'public');
        }

        Livro::create($data);
        return redirect()->route('livros')->with('success', '📚 Livro adicionado com sucesso!');
    }

    public function edit(Livro $livro)
    {
        $editoras = Editora::all();
        return view('livros.edit', compact('livro', 'editoras'));
    }

    public function update(Request $request, Livro $livro)
    {
        $data = $request->all();

        if ($request->hasFile('imagem_capa')) {
            $data['imagem_capa'] = $request->file('imagem_capa')->store('capas', 'public');
        }

        $livro->update($data);
        return redirect()->route('livros')->with('success', '📚 Livro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $livro = Livro::findOrFail($id);
        $livro->delete();

        return redirect()->route('livros')->with('success', '📖 Livro removido com sucesso!');
    }

}
