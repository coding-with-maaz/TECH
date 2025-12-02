<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programming',
                'slug' => 'programming',
                'description' => 'Articles about programming languages, coding practices, and software development.',
                'color' => '#3B82F6',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Frontend and backend web development tutorials, frameworks, and best practices.',
                'color' => '#10B981',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'iOS, Android, and cross-platform mobile app development guides.',
                'color' => '#8B5CF6',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'description' => 'AI, machine learning, deep learning, and neural networks articles.',
                'color' => '#EF4444',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'CI/CD, Docker, Kubernetes, cloud infrastructure, and deployment strategies.',
                'color' => '#F59E0B',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Database',
                'slug' => 'database',
                'description' => 'Database design, SQL, NoSQL, optimization, and management tutorials.',
                'color' => '#06B6D4',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'description' => 'Security best practices, vulnerabilities, encryption, and ethical hacking.',
                'color' => '#EC4899',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Tech News',
                'slug' => 'tech-news',
                'description' => 'Latest technology news, industry updates, and tech trends.',
                'color' => '#6366F1',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}

