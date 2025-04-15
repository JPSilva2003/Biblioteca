<?php

use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\RequisicaoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AlertaLivroController;
use App\Mail\EmailPadrao;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Http\Request;
use App\Models\Order;



Route::resource('livros', LivroController::class);
Route::resource('autores', AutorController::class);
Route::resource('editoras', EditoraController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/enviar-email', [MailController::class, 'enviarEmail']);
Route::get('/livros', [LivroController::class, 'index'])->name('livros');
Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
Route::get('/editoras', [EditoraController::class, 'index'])->name('editoras.index');
Route::get('/livros/{id}/export', [LivroController::class, 'export'])->name('livros.export');



// Rotas para CIDADÃOS
Route::middleware(['auth'])->group(function () {
    Route::post('/requisicoes/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::get('/reviews-user', [ReviewController::class, 'userReviews'])->name('reviews.user');


});

Route::post('/alertas', [\App\Http\Controllers\AlertaLivroController::class, 'store'])->name('alertas.store');
Route::post('/alertas', [AlertaLivroController::class, 'store'])->name('alertas.store');


Route::middleware(['auth'])->get('/user-reviews', [ReviewController::class, 'userReviews'])->name('reviews.user');




Route::middleware(['auth'])->group(function () {
    Route::resource('requisicoes', RequisicaoController::class);
    Route::patch('/requisicoes/{id}/confirmar', [RequisicaoController::class, 'confirmarRecebimento'])->name('requisicoes.confirmarRecebimento');
});



Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('livros.index', LivroController::class);
});

Route::middleware(['auth', 'role:Cidadão'])->group(function () {
    Route::get('/minhas-requisicoes', [RequisicaoController::class, 'minhasRequisicoes']);
});



Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users/{id}/updateRole', [UserController::class, 'updateRole'])->name('admin.users.updateRole');



Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);


Route::middleware(['auth'])->group(function () {
    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrinho/adicionar/{livroId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/carrinho/remover/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});




Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.index');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');





Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');

});


Route::post('/stripe/webhook', function (Request $request) {
    $payload = $request->all();

    if ($payload['type'] === 'checkout.session.completed') {
        $order = Order::where('id', $payload['data']['object']['metadata']['order_id'])->first();
        if ($order) {
            $order->update(['status' => 'pago']);
        }
    }

    return response()->json(['status' => 'success']);
});

Route::get('/test-email', function () {
    try {
        Mail::to('jppburn@gmail.com')->send(new EmailPadrao());
        return 'E-mail enviado com sucesso!';
    } catch (\Exception $e) {
        return 'Erro: ' . $e->getMessage();
    }
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
