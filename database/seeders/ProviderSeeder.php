<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Provider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            [
                'name' => 'Canva',
                'category' => 'Design & Creative',
                'website_url' => 'https://www.canva.com',
                'provider_type' => 'design',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Design and content creation platform for individuals, teams, and businesses.',
            ],
            [
                'name' => 'Adobe Creative Cloud',
                'category' => 'Design & Creative',
                'website_url' => 'https://www.adobe.com/creativecloud.html',
                'provider_type' => 'design',
                'risk_level' => 'medium',
                'allowed_status' => 'review_required',
                'description' => 'Professional creative software suite for design, video, photography, and media production.',
            ],
            [
                'name' => 'Google Workspace',
                'category' => 'Business Tools',
                'website_url' => 'https://workspace.google.com',
                'provider_type' => 'business',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Business email, cloud storage, documents, meetings, and team productivity tools.',
            ],
            [
                'name' => 'Microsoft 365',
                'category' => 'Business Tools',
                'website_url' => 'https://www.microsoft.com/microsoft-365',
                'provider_type' => 'business',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Business productivity suite including Office apps, email, cloud storage, and collaboration tools.',
            ],
            [
                'name' => 'Notion',
                'category' => 'Productivity',
                'website_url' => 'https://www.notion.so',
                'provider_type' => 'productivity',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Workspace for notes, documentation, project planning, databases, and team organization.',
            ],
            [
                'name' => 'Slack',
                'category' => 'Team Collaboration',
                'website_url' => 'https://slack.com',
                'provider_type' => 'collaboration',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Team communication and collaboration platform for business workspaces.',
            ],
            [
                'name' => 'Zoom',
                'category' => 'Team Collaboration',
                'website_url' => 'https://zoom.us',
                'provider_type' => 'collaboration',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Video conferencing, meetings, webinars, and team communication platform.',
            ],
            [
                'name' => 'Dropbox',
                'category' => 'Cloud Storage',
                'website_url' => 'https://www.dropbox.com',
                'provider_type' => 'cloud_storage',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Cloud storage, file sharing, backup, and team document management platform.',
            ],
            [
                'name' => 'ChatGPT',
                'category' => 'AI Tools',
                'website_url' => 'https://chatgpt.com',
                'provider_type' => 'ai',
                'risk_level' => 'medium',
                'allowed_status' => 'review_required',
                'description' => 'AI assistant for writing, research, productivity, coding, ideation, and business support.',
            ],
            [
                'name' => 'Grammarly',
                'category' => 'AI Tools',
                'website_url' => 'https://www.grammarly.com',
                'provider_type' => 'ai',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'AI writing assistant for grammar, clarity, tone, and business communication.',
            ],
            [
                'name' => 'NordVPN',
                'category' => 'VPN & Security',
                'website_url' => 'https://nordvpn.com',
                'provider_type' => 'security',
                'risk_level' => 'medium',
                'allowed_status' => 'review_required',
                'description' => 'VPN and online privacy tool for secure browsing and network protection.',
            ],
            [
                'name' => '1Password',
                'category' => 'VPN & Security',
                'website_url' => 'https://1password.com',
                'provider_type' => 'security',
                'risk_level' => 'low',
                'allowed_status' => 'approved',
                'description' => 'Password manager for individuals, teams, and businesses.',
            ],
        ];

        foreach ($providers as $provider) {
            $category = Category::where('name', $provider['category'])->first();

            Provider::updateOrCreate(
                ['slug' => Str::slug($provider['name'])],
                [
                    'category_id' => $category?->id,
                    'name' => $provider['name'],
                    'website_url' => $provider['website_url'],
                    'provider_type' => $provider['provider_type'],
                    'risk_level' => $provider['risk_level'],
                    'allowed_status' => $provider['allowed_status'],
                    'description' => $provider['description'],
                    'admin_notes' => null,
                    'status' => 'active',
                ]
            );
        }
    }
}