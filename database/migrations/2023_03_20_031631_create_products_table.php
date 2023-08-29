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
            $table->string('D_ProductID', 10)->nullable();
            $table->string('D_ProductName');
            $table->integer('D_ProductQty')->length(3);
            $table->decimal('D_ProductPrice', 5, 2)->default(0.00);
            $table->string('D_ProductBrand')->nullable();
            $table->string('D_ProductImage')->nullable();
            $table->integer('D_MinProductQty')->nullable();
            $table->string('D_Barcode')->nullable();
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
