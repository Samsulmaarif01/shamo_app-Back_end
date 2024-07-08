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
        Schema::create('product_galleries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('products_id')->unsigned(); // Menentukan bahwa ini adalah foreign key
            $table->foreign('products_id')->references('id')->on('products'); // Menambahkan foreign key constraint
            $table->string('url');
            $table->softDeletes();
            $table->timestamps();

            // Menambahkan indeks jika perlu untuk kolom products_id
            // $table->index('products_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_galleries');
    }
};
