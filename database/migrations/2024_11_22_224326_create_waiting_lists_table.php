<?php

use App\Enums\WaitingListStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->unsignedInteger('guests');
            $table->dateTime('from_time');
            $table->dateTime('to_time');
            $table->enum('status', WaitingListStatus::values())->default(WaitingListStatus::WAITING->value)->comment(WaitingListStatus::comment());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waiting_lists');
    }
};
