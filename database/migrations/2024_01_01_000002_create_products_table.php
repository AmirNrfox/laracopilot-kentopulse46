<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name_fa');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->text('description_fa')->nullable();
            $table->text('description_en')->nullable();
            $table->text('short_description_fa')->nullable();
            $table->text('short_description_en')->nullable();
            $table->string('brand')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->decimal('price', 12, 0);
            $table->decimal('sale_price', 12, 0)->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->string('main_image')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};