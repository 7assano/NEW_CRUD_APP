<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('app:api {module} {action} {id?}', function ($module, $action, $id = null) {
    
    // 1. الإعدادات الأساسية
    $token = env('API_TEST_TOKEN');
    $baseUrl = "http://127.0.0.1:8000/api/v1";
    
    if (!$token) {
        return $this->error("❌ API_TEST_TOKEN is missing in your .env file!");
    }

    $http = Http::withToken($token)->withHeaders(['Accept' => 'application/json']);

    $this->info("🚀 Module: [{$module}] | Action: [{$action}]" . ($id ? " | ID: {$id}" : ""));

    try {
        $response = null;

        switch ($module) {
            case 'task':
                switch ($action) {
                    case 'get':
                        $response = $http->get("{$baseUrl}/tasks" . ($id ? "/{$id}" : ""));
                        if ($response->successful() && !$id) {
                            $tasks = $response->json()['data'];
                            $this->table(['ID', 'Title', 'Priority', 'Status', 'Category'], array_map(fn($t) => [
                                $t['id'], $t['title'], $t['priority'], $t['is_completed'] ? '✅ Done' : '⏳ Pending', $t['category']['name'] ?? 'N/A'
                            ], $tasks));
                            return;
                        }
                        break;

                    case 'create':
                        $catRes = $http->get("{$baseUrl}/categories");
                        $categories = $catRes->successful() ? $catRes->json() : [];
                        $this->info("💡 Available Categories:");
                        foreach($categories as $c) { $this->line("- [ID: {$c['id']}] {$c['name']}"); }

                        $data = [
                            'title'       => $this->ask('📝 Enter Task Title'),
                            'description' => $this->ask('📖 Enter Description (Optional)'),
                            'priority'    => $this->choice('⚡ Priority', ['low', 'medium', 'high'], 1),
                            'category_id' => $this->ask('📂 Enter Category ID', null),
                        ];
                        $response = $http->post("{$baseUrl}/tasks", array_filter($data));
                        break;

                    case 'update':
                        $completed = $this->confirm('✅ Mark as completed?', true);
                        $response = $http->patch("{$baseUrl}/tasks/{$id}", ['is_completed' => $completed]);
                        break;

                    case 'delete':
                        if ($this->confirm("⚠️ Are you sure you want to delete task #{$id}?")) {
                            $response = $http->delete("{$baseUrl}/tasks/{$id}");
                        }
                        break;
                }
                break;

            case 'trash':
                switch ($action) {
                    case 'get':
                        $response = $http->get("{$baseUrl}/tasks/trash");
                        if ($response->successful()) {
                            $tasks = $response->json()['data'] ?? $response->json();
                            $this->table(['ID', 'Deleted Title', 'Priority'], array_map(fn($t) => [$t['id'], $t['title'], $t['priority']], $tasks));
                            return;
                        }
                        break;
                    case 'restore': $response = $http->post("{$baseUrl}/tasks/{$id}/restore"); break; 
                    case 'force':   $response = $http->delete("{$baseUrl}/tasks/{$id}/force"); break;
                }
                break;

            case 'category':
                $response = $http->get("{$baseUrl}/categories");
                if ($response->successful()) {
                    $categories = $response->json();
                    $tableData = isset($categories['data']) ? $categories['data'] : $categories;
                    $this->table(['ID', 'Category Name'], array_map(fn($c) => [$c['id'], $c['name']], $tableData));
                    return;
                }
                break;

            case 'profile':
                switch ($action) {
                    case 'get': $response = $http->get("{$baseUrl}/profile"); break;
                    case 'update': 
                        $response = $http->post("{$baseUrl}/profile", [
                            'bio' => $this->ask('📝 Enter Bio'),
                            'phone' => $this->ask('📞 Enter Phone')
                        ]); 
                        break;
                    case 'upload': 
                        $imageName = $this->ask('🖼️ Image name in public/images', 'default-avatar.png');
                        $path = public_path("images/{$imageName}");
                        if (!File::exists($path)) return $this->error("❌ File not found at public/images/{$imageName}");
                        $response = $http->attach('avatar', file_get_contents($path), $imageName)->post("{$baseUrl}/profile/avatar");
                        break;
                    case 'delete-img': 
                        $response = $http->delete("{$baseUrl}/profile/avatar"); 
                        break;
                }
                break;
        }

        // 3. معالجة الرد العام
        if ($response) {
            $status = $response->status();
            $color = $response->successful() ? 'info' : 'error';
            $this->$color("📡 Status: {$status}");
            dump($response->json());
        }

    } catch (\Exception $e) {
        $this->error("‼️ System Error: " . $e->getMessage());
    }

})->purpose('The Ultimate Professional API Interactive Tool');