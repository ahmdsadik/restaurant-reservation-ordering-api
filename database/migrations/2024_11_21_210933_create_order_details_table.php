<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('meal_id')->constrained('meals');
            $table->unsignedTinyInteger('quantity');
            $table->decimal('amount_to_pay')->unsigned();

            $table->primary(['order_id', 'meal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
