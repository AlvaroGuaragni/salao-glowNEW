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
        // Criar tabela pivot
        Schema::create('agendamento_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agendamento_id');
            $table->unsignedBigInteger('servico_id');
            $table->timestamps();
            
            $table->foreign('agendamento_id')->references('id')->on('agendamentos')->onDelete('cascade');
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade');
            
            // Evitar duplicatas
            $table->unique(['agendamento_id', 'servico_id']);
        });

        // Remover coluna servico_id da tabela agendamentos
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropForeign(['servico_id']);
            $table->dropColumn('servico_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Adicionar coluna servico_id de volta
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('servico_id')->nullable();
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade');
        });

        // Remover tabela pivot
        Schema::dropIfExists('agendamento_servico');
    }
};
