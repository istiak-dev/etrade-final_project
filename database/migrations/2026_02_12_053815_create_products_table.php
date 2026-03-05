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
            $table->foreignId('category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();           
            $table->string('brand_name')->nullable();
            $table->string('model')->nullable()->unique();
            $table->string('sku')->nullable()->unique();
            $table->integer('stock')->default(0);
            $table->integer('minstock')->default(0);
            $table->boolean('stock_status')->default(true);
            $table->integer('price');
            $table->integer('sale_price')->nullable();
            
            $table->dateTime('deal_date')->nullable();
            $table->boolean('deal_status')->default(false);
            
            $table->string('image')->nullable();
            $table->json('gall_img')->nullable();
            $table->string('published_status')->nullable();
            $table->date('published_date')->nullable();            
            $table->timestamps();
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
