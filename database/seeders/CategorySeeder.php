<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Design & Creative',
                'description' => 'Tools for graphic design, branding, content creation, and creative workflows.',
            ],
            [
                'name' => 'Productivity',
                'description' => 'Tools for planning, organizing, documentation, and daily productivity.',
            ],
            [
                'name' => 'AI Tools',
                'description' => 'AI-powered tools for writing, research, automation, design, and business support.',
            ],
            [
                'name' => 'Team Collaboration',
                'description' => 'Tools for communication, project coordination, team workspaces, and internal operations.',
            ],
            [
                'name' => 'Cloud Storage',
                'description' => 'Cloud-based file storage, backup, sharing, and document management tools.',
            ],
            [
                'name' => 'Business Tools',
                'description' => 'General business tools for operations, finance, marketing, CRM, and administration.',
            ],
            [
                'name' => 'VPN & Security',
                'description' => 'Security, privacy, VPN, password management, and protection tools.',
            ],
            [
                'name' => 'Learning',
                'description' => 'Learning platforms, online course tools, and professional development resources.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'status' => 'active',
                ]
            );
        }
    }
}