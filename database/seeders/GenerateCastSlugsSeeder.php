<?php

namespace Database\Seeders;

use App\Models\Cast;
use Illuminate\Database\Seeder;

class GenerateCastSlugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $casts = Cast::whereNull('slug')->get();
        
        foreach ($casts as $cast) {
            $cast->slug = $cast->generateUniqueSlug();
            $cast->save();
        }
        
        $this->command->info("Generated slugs for {$casts->count()} cast members.");
    }
}

