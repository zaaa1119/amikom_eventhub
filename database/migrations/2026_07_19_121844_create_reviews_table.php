<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1 - 5
            $table->text('comment')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'user_id']); // 1 user cuma boleh 1 review per event
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};