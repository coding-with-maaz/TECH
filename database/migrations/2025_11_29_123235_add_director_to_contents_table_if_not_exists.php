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
        // Add network column if it doesn't exist
        if (!Schema::hasColumn('contents', 'network')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->string('network')->nullable();
            });
        }
        
        // Add duration column if it doesn't exist
        if (!Schema::hasColumn('contents', 'duration')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->integer('duration')->nullable();
            });
        }
        
        // Add country column if it doesn't exist
        if (!Schema::hasColumn('contents', 'country')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->string('country')->nullable();
            });
        }
        
        // Add director column if it doesn't exist
        if (!Schema::hasColumn('contents', 'director')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->string('director')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove columns if they exist
        if (Schema::hasColumn('contents', 'director')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('director');
            });
        }
        
        if (Schema::hasColumn('contents', 'country')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('country');
            });
        }
        
        if (Schema::hasColumn('contents', 'duration')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('duration');
            });
        }
        
        if (Schema::hasColumn('contents', 'network')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('network');
            });
        }
    }
};
