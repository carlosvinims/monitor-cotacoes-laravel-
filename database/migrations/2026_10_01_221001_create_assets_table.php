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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->string('type', 10);
            $table->string('symbol', 10);
            $table->decimal('current_price', 12, 4)->default(0);
            $table->decimal('high_price', 12, 4)->default(0);
            $table->decimal('low_price', 12, 4)->default(0);
            $table->decimal('variation_24h', 8, 2)->default(0);
            $table->timestamps();
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
