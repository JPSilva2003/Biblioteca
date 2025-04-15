<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Validação da morada
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())->with('livro')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'O carrinho está vazio.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        $total = 0;

        foreach ($cartItems as $item) {
            $preco = $item->livro->preco * 100; // Stripe usa valores em centavos
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->livro->nome,
                    ],
                    'unit_amount' => $preco,
                ],
                'quantity' => $item->quantidade,
            ];
            $total += $item->livro->preco * $item->quantidade;
        }

        // Criar a encomenda antes de processar o pagamento, incluindo a morada
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pendente',
            'address' => $request->address, // Adiciona a morada
        ]);

        // Armazena o ID da encomenda na sessão para futura atualização
        session(['order_id' => $order->id]);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('cart.index'),
        ]);

        return redirect($session->url);
    }


    public function success()
    {
        // Procura a última encomenda pendente do utilizador
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pendente')
            ->latest()
            ->first();

        if ($order) {
            // Atualiza para "pago"
            $order->status = 'pago';
            $order->save();

            // Limpa o carrinho
            CartItem::where('user_id', Auth::id())->delete();
        }

        // Redireciona para o Dashboard com mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Pagamento concluído com sucesso!');
    }



}
