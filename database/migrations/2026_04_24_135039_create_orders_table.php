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
        Schema::create('orders', function (Blueprint $table) {
            // 'id' int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT
            $table->id();

            // 'name' varchar(255) DEFAULT NULL
            $table->string('name', 255)->nullable();

            // 'email' varchar(30) DEFAULT NULL
            $table->string('email', 30)->nullable();

            // 'phone' varchar(20) DEFAULT NULL
            $table->string('phone', 20)->nullable();

            // 'amount' double DEFAULT NULL
            $table->double('amount')->nullable();

            // 'address' text DEFAULT NULL
            $table->text('address')->nullable();

            // 'status' varchar(10) DEFAULT NULL
            $table->string('status', 10)->nullable();

            // 'transaction_id' varchar(255) DEFAULT NULL
            $table->string('transaction_id', 255)->nullable();

            // 'currency' varchar(20) DEFAULT NULL
            $table->string('currency', 20)->nullable();

            // Optional: Laravel usually expects these for created_at/updated_at
            // $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
