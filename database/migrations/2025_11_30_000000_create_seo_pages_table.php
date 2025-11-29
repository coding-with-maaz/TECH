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
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique(); // e.g., 'home', 'movies.index', 'movies.show', 'cast.index', etc.
            $table->string('page_name'); // Display name: 'Home Page', 'Movies List', etc.
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable(); // Comma-separated keywords
            $table->text('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable(); // OG image URL
            $table->text('og_url')->nullable();
            $table->text('twitter_card')->nullable(); // summary, summary_large_image
            $table->text('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->text('canonical_url')->nullable();
            $table->text('schema_markup')->nullable(); // JSON-LD structured data
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('page_key');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};

