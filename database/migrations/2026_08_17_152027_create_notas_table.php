<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
             $table->id();
             $table->foreignId('aluno_id')->constrained()->onDelete('cascade');
             $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
             $table->decimal('nota_1', 4, 2)->nullable();
             $table->decimal('nota_2', 4, 2)->nullable();
             $table->decimal('media', 4, 2)->nullable();
             $table->integer('faltas')->default(0);
             $table->string('situacao')->default('Em Andamento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
