<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_admin_routes()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/statistics');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'total_tasks',
                    'completed_tasks',
                    'pending_tasks',
                ]
            ]);
    }

    /** @test */
    public function regular_user_cannot_access_admin_routes()
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/admin/statistics');

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized. Admin access only.',
            ]);
    }

    /** @test */
    public function admin_can_view_all_tasks()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Task::factory()->count(2)->create(['user_id' => $user1->id]);
        Task::factory()->count(3)->create(['user_id' => $user2->id]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    /** @test */
    public function admin_can_delete_any_task()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/v1/admin/tasks/{$task->id}");

        $response->assertStatus(200);

        // المهمة موجودة لكن محذوفة (Soft Delete)
        $this->assertSoftDeleted('tasks', [
            'id' => $task->id,
        ]);
    }
}
