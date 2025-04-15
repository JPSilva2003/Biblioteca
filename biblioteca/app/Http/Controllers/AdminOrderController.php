<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));

    }

    public function finalizarCompra(Request $request) {
        $order = Order::where('user_id', auth()->id())->where('status', 'pendente')->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Nenhuma compra pendente encontrada.');
        }

        $order->status = 'pago';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Compra finalizada com sucesso!');
    }

}

