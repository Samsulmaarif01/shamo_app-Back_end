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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id')->unsigned(); // Menentukan bahwa ini adalah foreign key
            $table->foreign('users_id')->references('id')->on('users'); // Menambahkan foreign key constraint
            $table->text('address')->nullable();
            $table->float('total_price')->default(0);
            $table->float('shipping_price')->default(0);
            $table->string('status')->default('PENDING');
            $table->string('payment')->default('MANUAL');
            $table->softDeletes();
            $table->timestamps();

            // Menambahkan indeks jika perlu untuk kolom users_id
            // $table->index('users_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
