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
        Schema::create('pedido_itens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('pedido_id')->constrained(
                table: 'pedidos', indexName: 'pedido_item_pedido_id'
            );
            $table->foreignId('produto_id')->constrained(
                table: 'produtos', indexName: 'pedido_item_produto_id'
            );
            $table->float('valor');
            $table->float('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_itens');
    }
};
