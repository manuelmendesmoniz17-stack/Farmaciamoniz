<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nif')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->text('endereco')->nullable();
            $table->timestamps();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->text('endereco')->nullable();
            $table->timestamps();
        });

        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome_comercial');
            $table->string('principio_ativo')->nullable();
            $table->string('categoria')->nullable();
            $table->string('fabricante')->nullable();
            $table->string('lote')->nullable();
            $table->date('data_fabricacao')->nullable();
            $table->date('data_validade')->nullable();
            $table->decimal('preco_compra', 12, 2)->default(0);
            $table->decimal('preco_venda', 12, 2)->default(0);
            $table->integer('quantidade')->default(0);
            $table->integer('estoque_minimo')->default(10);
            $table->foreignId('fornecedor_id')->nullable()->constrained('fornecedores')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_fatura')->unique();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('desconto', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('forma_pagamento', ['dinheiro', 'multicaixa', 'transferencia'])->default('dinheiro');
            $table->timestamps();
        });

        Schema::create('venda_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained('vendas')->cascadeOnDelete();
            $table->foreignId('medicamento_id')->constrained('medicamentos')->cascadeOnDelete();
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });

        Schema::create('estoque_movimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicamento_id')->constrained('medicamentos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('venda_id')->nullable()->constrained('vendas')->nullOnDelete();
            $table->enum('tipo', ['compra', 'doacao', 'ajuste', 'venda', 'perda', 'vencido']);
            $table->integer('quantidade');
            $table->text('observacao')->nullable();
            $table->timestamps();
        });

        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_farmacia')->default('Farmacia');
            $table->string('logotipo')->nullable();
            $table->text('endereco')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
        Schema::dropIfExists('estoque_movimentos');
        Schema::dropIfExists('venda_itens');
        Schema::dropIfExists('vendas');
        Schema::dropIfExists('medicamentos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('fornecedores');
    }
};
