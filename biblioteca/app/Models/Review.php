<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requisicao_id',
        'conteudo',
        'estado',
        'justificacao',
    ];

    // Relação com o utilizador que fez o review
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relação com a requisição à qual o review pertence
    public function requisicao()
    {
        return $this->belongsTo(Requisicao::class);
    }
}
