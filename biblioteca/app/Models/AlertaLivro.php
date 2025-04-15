<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertaLivro extends Model
{
    use HasFactory;

    protected $table = 'alertas_livros';

    protected $fillable = [
        'user_id',
        'livro_id',
        'notificado',
    ];

    // 🔁 Relação com o utilizador
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 📚 Relação com o livro
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
