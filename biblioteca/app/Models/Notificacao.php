<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'titulo',
        'mensagem',
        'lida',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
