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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('download_link'); // Real Mega/GDrive link
            $table->string('quality')->nullable(); // 4K, 1080p, etc.
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->integer('article_id')->nullable(); // Optional: specific article to use
            $table->integer('category_id')->nullable(); // Optional: category-based article selection
            $table->boolean('is_active')->default(true);
            $table->integer('redirect_count')->default(0); // Track redirects
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
