<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('senderUser_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('receiverUser_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('senderDriver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('receiverDriver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();
            $table->longText('message');
            $table->boolean('is_edited')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
