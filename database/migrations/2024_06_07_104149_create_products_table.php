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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->longText('description');
            $table->string('tags')->nullable();
            $table->bigInteger('categories_id')->unsigned(); // Menentukan bahwa ini adalah foreign key
            $table->foreign('categories_id')->references('id')->on('product_categories'); // Menambahkan foreign key constraint
            $table->softDeletes();
            $table->timestamps();

            // Menambahkan indeks jika perlu untuk kolom categories_id
            // $table->index('categories_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
