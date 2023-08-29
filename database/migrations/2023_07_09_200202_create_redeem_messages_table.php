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
        Schema::create('redeem_messages', function (Blueprint $table) {
            $table->id();
            $table->string('D_RedeemCusName');
            $table->string('D_RedeemCusMessage');
            $table->integer('D_RedeemQuantity');
            $table->string('D_RedeemStatus')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_messages');
    }
};
