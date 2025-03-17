<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Editora extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'logotipo'];

    public function livros()
    {
        return $this->hasMany(Livro::class);
    }
}
