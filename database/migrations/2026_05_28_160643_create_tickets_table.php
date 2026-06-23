<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('subject'); 
            $table->enum('status', ['OPEN', 'RESOLVED'])->default('OPEN');
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->unsignedBigInteger('driver_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
