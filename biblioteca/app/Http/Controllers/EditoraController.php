<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Editora;
class EditoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $editoras = editora::all();
        return view('editoras.index', compact('editoras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('editoras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('editoras_logos', 'public');
        }

        Editora::create([
            'nome' => $request->nome,
            'logo' => $logoPath,
        ]);

        return redirect()->route('editoras.index')->with('success', 'Editora adicionada com sucesso!');
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
    public function edit($id)
    {
        $editora = Editora::findOrFail($id);
        return view('editoras.edit', compact('editora'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $editora = Editora::findOrFail($id);
        $logoPath = $editora->logo;

        if ($request->hasFile('logo')) {
            // Remove a logo antiga se existir
            if ($editora->logo) {
                Storage::disk('public')->delete($editora->logo);
            }
            // Salva a nova logo
            $logoPath = $request->file('logo')->store('editoras_logos', 'public');
        }

        $editora->update([
            'nome' => $request->nome,
            'logo' => $logoPath,
        ]);

        return redirect()->route('editoras.index')->with('success', 'Editora atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $editora = Editora::findOrFail($id);

        // Remove a logo se existir
        if ($editora->logo) {
            Storage::disk('public')->delete($editora->logo);
        }

        $editora->delete();

        return redirect()->route('editoras.index')->with('success', 'Editora removida com sucesso!');
    }
}
