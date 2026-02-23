<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products')) return;

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name_fa');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->string('brand')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->integer('price')->default(0);
            $table->integer('sale_price')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->string('main_image')->nullable();
            $table->text('description_fa')->nullable();
            $table->text('description_en')->nullable();
            $table->string('short_description_fa', 500)->nullable();
            $table->string('short_description_en', 500)->nullable();
            $table->float('weight')->nullable();
            $table->integer('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};