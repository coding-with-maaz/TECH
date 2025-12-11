<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@techblog.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_author' => true,
                'role' => 'admin',
                'bio' => 'Administrator and lead author of Nazaaracircle.',
                'website' => 'https://nazaaracircle.com',
            ]
        );

        // Create author user
        $author = User::firstOrCreate(
            ['email' => 'author@techblog.com'],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_author' => true,
                'role' => 'author',
                'bio' => 'Full-stack developer and tech enthusiast. Love sharing knowledge about web development and programming.',
                'website' => 'https://johndoe.dev',
                'twitter' => '@johndoe',
                'github' => 'johndoe',
            ]
        );

        // Create regular user
        $user = User::firstOrCreate(
            ['email' => 'user@techblog.com'],
            [
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_author' => false,
                'role' => 'user',
            ]
        );

        $this->command->info('✅ Users seeded successfully!');
        $this->command->info("Admin: admin@techblog.com / password");
        $this->command->info("Author: author@techblog.com / password");
        $this->command->info("User: user@techblog.com / password");
    }
}

