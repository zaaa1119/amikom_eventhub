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
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jabatan_id')
                  ->constrained('jabatans')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->decimal('salary', 15, 2);

            $table->string('created_by', 100);
            $table->timestamp('created_at')->useCurrent();

            $table->string('updated_by', 100)->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penguruses');
    }
};
