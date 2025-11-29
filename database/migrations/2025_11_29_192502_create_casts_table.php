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
        Schema::create('casts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Cast member name (unique to prevent duplicates)
            $table->string('profile_path')->nullable(); // Profile image URL
            $table->text('biography')->nullable(); // Optional biography
            $table->date('birthday')->nullable(); // Optional birthday
            $table->string('birthplace')->nullable(); // Optional birthplace
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casts');
    }
};
