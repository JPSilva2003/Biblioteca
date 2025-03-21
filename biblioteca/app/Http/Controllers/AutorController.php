<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autor;


class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $autores = Autor::all();
        return view('autores.index', compact('autores'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('autores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Salvar a imagem
        $imagemPath = $request->file('foto')->store('autores', 'public');

        Autor::create([
            'nome' => $request->nome,
            'foto' => $imagemPath,
        ]);

        return redirect()->route('autores.index')->with('success', 'Autor adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
