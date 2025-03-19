<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;



Route::resource('livros', LivroController::class);
Route::resource('autores', AutorController::class);
Route::resource('editoras', EditoraController::class);

Route::get('/', function () {
    return view('welcome');
});


Route::get('/livros', [LivroController::class, 'index'])->name('livros');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/menu', function () {
        return view('dashboard');
    })->name('dashboard');
});
