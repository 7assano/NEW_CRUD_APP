<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_create_task()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/v1/tasks', [
                'title' => 'Test Task',
                'description' => 'Test Description',
                'priority' => 'high',
                'category_id' => $category->id,
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'priority',
                    'priority_icon',
                ]
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_create_task()
    {
        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'priority' => 'high',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_view_their_tasks()
    {
        Task::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function authenticated_user_cannot_view_other_users_tasks()
    {
        $otherUser = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function authenticated_user_can_update_their_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/v1/tasks/{$task->id}", [
                'title' => 'Updated Title',
                'description' => 'Updated Description',
                'priority' => 'low',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    /** @test */
    public function authenticated_user_can_delete_their_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(200);

        // المهمة موجودة لكن محذوفة (Soft Delete)
        $this->assertSoftDeleted('tasks', [
            'id' => $task->id,
        ]);
    }

    /** @test */
    public function authenticated_user_can_toggle_task_completion()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'is_completed' => false,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->patchJson("/api/v1/tasks/{$task->id}/toggle");

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }

    /** @test */
    public function authenticated_user_can_toggle_task_favorite()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'is_favorite' => false,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->patchJson("/api/v1/tasks/{$task->id}/favorite");

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_favorite' => true,
        ]);
    }
}
