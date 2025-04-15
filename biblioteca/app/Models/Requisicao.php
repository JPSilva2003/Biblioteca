<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisicao extends Model
{
    use HasFactory;

    protected $table = 'requisicoes';

    protected $fillable = ['user_id', 'livro_id', 'data_requisicao', 'data_prevista_entrega', 'status', 'foto_cidadao' ];

    protected $dates = [
        'data_requisicao',
        'data_prevista_entrega',
    ];

    /**
     * Relacionamento: Uma requisição pertence a um usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relacionamento: Uma requisição pertence a um livro.
     */
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function review()
    {
        return $this->hasOne(\App\Models\Review::class);
    }

    public $timestamps = true;
}
