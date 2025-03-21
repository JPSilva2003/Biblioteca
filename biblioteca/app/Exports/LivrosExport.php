<?php

namespace App\Exports;

use App\Models\Livro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LivrosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Livro::all([
            'isbn', 'nome', 'autores', 'editora_id', 'bibliografia', 'imagem_capa', 'preco'
        ]);
    }

    public function headings(): array
    {
        return ['ISBN', 'Nome', 'Autor', 'Editora', 'Bibliografia', 'Imagem da Capa', 'Preço'];
    }
}
