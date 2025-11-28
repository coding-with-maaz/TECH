<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\Episode;

class GenerateSlugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate slugs for existing content
        $contents = Content::whereNull('slug')->get();
        foreach ($contents as $content) {
            $content->slug = $content->generateUniqueSlug();
            $content->save();
            $this->command->info("Generated slug for: {$content->title} -> {$content->slug}");
        }

        // Generate slugs for existing episodes
        $episodes = Episode::whereNull('slug')->get();
        foreach ($episodes as $episode) {
            $episode->slug = $episode->generateUniqueSlug();
            $episode->save();
            $this->command->info("Generated slug for episode: {$episode->title} -> {$episode->slug}");
        }

        $this->command->info("✅ All slugs generated successfully!");
    }
}

