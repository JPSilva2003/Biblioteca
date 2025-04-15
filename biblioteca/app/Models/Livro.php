<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = ['isbn', 'nome', 'editora_id', 'bibliografia', 'imagem_capa','autores', 'preco', 'disponivel'];

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class);
    }

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class, 'livro_id');
    }

    public function alertas()
    {
        return $this->hasMany(\App\Models\AlertaLivro::class);
    }


}
