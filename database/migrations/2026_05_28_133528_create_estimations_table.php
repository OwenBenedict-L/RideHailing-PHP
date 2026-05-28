<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estimations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('fare')->nullable();
            $table->integer('estimated_time')->nullable();
            $table->decimal('surge_multiplier', 8, 2)->default(1.0);
            $table->string('status')->default('ACTIVE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimations');
    }
};