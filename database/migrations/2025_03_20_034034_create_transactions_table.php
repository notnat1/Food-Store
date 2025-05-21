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
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('city_id');
            $table->string('invoice');
            $table->integer('weight');
            $table->text('address');
            $table->decimal('total', 8, 2);
            $table->enum('status', ['pending', 'success', 'expired', 'failed'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->timestamps();

            // Foreign key relations
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
