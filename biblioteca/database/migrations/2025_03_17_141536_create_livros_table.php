<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('nome');
            $table->foreignId('editora_id')->constrained('editoras')->onDelete('cascade');
            $table->text('bibliografia')->nullable();
            $table->string('imagem_capa')->nullable();
            $table->decimal('preco', 8, 2);
            $table->timestamps();
        });

        Schema::create('autor_livro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('autor_id')->constrained('autores')->onDelete('cascade');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
