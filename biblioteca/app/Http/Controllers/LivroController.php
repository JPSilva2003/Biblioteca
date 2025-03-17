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
        Livro::create($request->all());
        return redirect()->route('livros.index');
    }

    public function edit(Livro $livro)
    {
        $editoras = Editora::all();
        return view('livros.edit', compact('livro', 'editoras'));
    }

    public function update(Request $request, Livro $livro)
    {
        $livro->update($request->all());
        return redirect()->route('livros.index');
    }

    public function destroy(Livro $livro)
    {
        $livro->delete();
        return redirect()->route('livros.index');
    }
}
