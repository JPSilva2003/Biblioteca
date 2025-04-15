<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Event;
use App\Models\Order;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Chave secreta do Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->all();
        $event = Event::constructFrom($payload);

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Obtém a encomenda pelo ID armazenado na sessão Stripe
            $orderId = session('order_id');

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && $order->status === 'pendente') {
                    $order->status = 'pago';
                    $order->save();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
