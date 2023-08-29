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
        Schema::create('redeem_items', function (Blueprint $table) {
            $table->id();
            $table->string('D_RedeemItemID', 10)->nullable();
            $table->string('D_RedeemItemName');
            $table->integer('D_RedeemItemQty')->length(3);
            $table->integer('D_RedeemItemPoint')->length(3);
            $table->string('D_RedeemItemImage')->nullable();
            $table->string('D_RedeemItemStatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_items');
    }
};
