<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Livro;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $cartItems = CartItem::where('user_id', Auth::id())->with('livro')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart($livroId) {
        $cartItem = CartItem::where('user_id', Auth::id())->where('livro_id', $livroId)->first();

        if ($cartItem) {
            $cartItem->increment('quantidade');
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'livro_id' => $livroId,
                'quantidade' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Livro adicionado ao carrinho!');
    }

    public function removeFromCart($id) {
        $cartItem = CartItem::where('id', $id)->where('user_id', Auth::id())->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Item removido do carrinho.');
    }
}
