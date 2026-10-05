<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('tipo', ['local', 'retirada', 'entrega'])->default('retirada');
            $table->enum('status', [
                'recebido',
                'em_preparo',
                'pronto',
                'saiu_entrega',
                'entregue',
                'cancelado',
            ])->default('recebido');
            $table->enum('forma_pagamento', [
                'dinheiro',
                'pix',
                'cartao_credito',
                'cartao_debito',
            ])->default('pix');
            $table->text('observacoes')->nullable();
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
