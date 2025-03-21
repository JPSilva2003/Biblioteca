<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Autor extends Model
{
    use HasFactory;


    protected $table = 'autores';
    public $timestamps = false;
    protected $fillable = ['nome', 'foto'];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro');
    }
}
