<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'React', 'Vue.js', 'Angular',
            'Node.js', 'Python', 'Django', 'Flask', 'Java', 'Spring Boot', 'C#', '.NET',
            'Go', 'Rust', 'Swift', 'Kotlin', 'Dart', 'Flutter', 'React Native',
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Elasticsearch',
            'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP', 'Git', 'GitHub',
            'REST API', 'GraphQL', 'Microservices', 'Serverless',
            'Machine Learning', 'Deep Learning', 'TensorFlow', 'PyTorch',
            'HTML', 'CSS', 'SASS', 'Tailwind CSS', 'Bootstrap',
            'Linux', 'Ubuntu', 'Nginx', 'Apache',
            'Testing', 'Unit Testing', 'TDD', 'CI/CD',
            'Agile', 'Scrum', 'Project Management',
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['name' => $tagName],
                [
                    'name' => $tagName,
                    'slug' => \Illuminate\Support\Str::slug($tagName),
                ]
            );
        }

        $this->command->info('✅ Tags seeded successfully!');
    }
}

