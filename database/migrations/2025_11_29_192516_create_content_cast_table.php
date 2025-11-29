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
        Schema::create('content_cast', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('contents')->onDelete('cascade');
            $table->foreignId('cast_id')->constrained('casts')->onDelete('cascade');
            $table->string('character')->nullable(); // Character name in this content
            $table->integer('order')->default(0); // Display order
            $table->timestamps();
            
            $table->unique(['content_id', 'cast_id']); // Prevent duplicate cast per content
            $table->index(['content_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_cast');
    }
};
