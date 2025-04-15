<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'livro_id', 'quantidade'];

    public function livro() {
        return $this->belongsTo(Livro::class);
    }
}
