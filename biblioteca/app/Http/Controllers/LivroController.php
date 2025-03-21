<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Exports\LivrosExport;
use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Editora;
use App\Models\Autor;
class LivroController extends Controller
{
    public function index(Request $request)
    {
        $query = Livro::query();

        // Filtro por pesquisa (nome do livro ou autor)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('autores', 'like', "%{$search}%");
        }

        // Filtro por editora
        if ($request->filled('editora_id')) {
            $query->where('editora_id', $request->editora_id);
        }

        $livros = $query->paginate(10);
        $editoras = Editora::all();

        return view('livros.index', compact('livros', 'editoras'));
    }


    public function create()
    {
        $editoras = Editora::all();
        $autores = Autor::all();
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

    public function show($id)
    {
        $livro = Livro::findOrFail($id);
        return view('livros.show', compact('livro'));
    }

    public function destroy($id)
    {
        $livro = Livro::findOrFail($id);
        $livro->delete();

        return redirect()->route('livros')->with('success', '📖 Livro removido com sucesso!');
    }


    public function export($id)
    {
        $livro = Livro::findOrFail($id);

        $csvData = [
            ["ISBN", "Nome", "Autor", "Editora", "Bibliografia", "Preço"],
            [$livro->isbn, $livro->nome, $livro->autores, $livro->editora->nome, $livro->bibliografia, $livro->preco]
        ];

        $filename = "livro_{$livro->id}.csv";

        $handle = fopen('php://temp', 'w+');
        foreach ($csvData as $row) {
            fputcsv($handle, $row, ';');
        }
        rewind($handle);

        return Response::make(stream_get_contents($handle), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }


}
