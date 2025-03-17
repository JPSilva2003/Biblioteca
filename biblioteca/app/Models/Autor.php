<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'foto'];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro');
    }
}
