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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id')->unsigned(); // Menentukan bahwa ini adalah foreign key
            $table->bigInteger('products_id')->unsigned(); // Menentukan bahwa ini adalah foreign key
            $table->bigInteger('transactions_id')->unsigned(); // Menentukan bahwa ini adalah foreign key
            $table->bigInteger('quantity');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('products_id')->references('id')->on('products');
            $table->foreign('transactions_id')->references('id')->on('transactions');

            // Menambahkan indeks jika perlu untuk kolom users_id, products_id, atau transactions_id
            // $table->index('users_id');
            // $table->index('products_id');
            // $table->index('transactions_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
