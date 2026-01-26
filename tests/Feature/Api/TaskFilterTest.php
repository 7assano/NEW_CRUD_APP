<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function can_search_tasks_by_title()
    {
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Fix Critical Bug',
        ]);

        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Write Documentation',
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks?search=bug');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Fix Critical Bug');
    }

    /** @test */
    public function can_filter_tasks_by_priority()
    {
        Task::factory()->create([
            'user_id' => $this->user->id,
            'priority' => 'high',
        ]);

        Task::factory()->create([
            'user_id' => $this->user->id,
            'priority' => 'low',
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks?priority=high');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.priority', 'high');
    }

    /** @test */
    public function can_filter_completed_tasks()
    {
        Task::factory()->create([
            'user_id' => $this->user->id,
            'is_completed' => true,
        ]);

        Task::factory()->create([
            'user_id' => $this->user->id,
            'is_completed' => false,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks?completed=true');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.is_completed', true);
    }

    /** @test */
    public function can_filter_favorite_tasks()
    {
        Task::factory()->create([
            'user_id' => $this->user->id,
            'is_favorite' => true,
        ]);

        Task::factory()->create([
            'user_id' => $this->user->id,
            'is_favorite' => false,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks?favorites=true');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.is_favorite', true);
    }

    /** @test */
    public function can_sort_tasks_by_created_at()
    {
        $oldTask = Task::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => now()->subDays(2),
        ]);

        $newTask = Task::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks?sort_by=created_at&sort_order=desc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.id', $newTask->id)
            ->assertJsonPath('data.1.id', $oldTask->id);
    }
}
