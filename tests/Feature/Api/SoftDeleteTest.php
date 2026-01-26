<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function deleted_task_moves_to_trash()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(200);

        // المهمة لا تظهر في القائمة العادية
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'deleted_at' => null,
        ]);

        // لكن موجودة في Database مع deleted_at
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
        ]);
    }

    /** @test */
    public function user_can_view_their_trash()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $task->delete();

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/tasks/trash');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $task->id);
    }

    /** @test */
    public function user_can_restore_their_deleted_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $task->delete();

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/v1/tasks/{$task->id}/restore");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'تم استرجاع المهمة بنجاح',
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function user_can_force_delete_their_task()
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $task->delete();

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/v1/tasks/{$task->id}/force");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'تم حذف المهمة نهائياً',
            ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    /** @test */
    public function user_can_empty_their_trash()
    {
        $task1 = Task::factory()->create(['user_id' => $this->user->id]);
        $task2 = Task::factory()->create(['user_id' => $this->user->id]);
        $task3 = Task::factory()->create(['user_id' => $this->user->id]);

        $task1->delete();
        $task2->delete();
        $task3->delete();

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson('/api/v1/tasks/trash/empty');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
            ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task1->id,
        ]);
        $this->assertDatabaseMissing('tasks', [
            'id' => $task2->id,
        ]);
        $this->assertDatabaseMissing('tasks', [
            'id' => $task3->id,
        ]);
    }

    /** @test */
    public function admin_can_view_all_trashed_tasks()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $task1 = Task::factory()->create(['user_id' => $user1->id]);
        $task2 = Task::factory()->create(['user_id' => $user2->id]);

        $task1->delete();
        $task2->delete();

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/tasks/trash');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function admin_can_restore_any_task()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $task->delete();

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson("/api/v1/admin/tasks/{$task->id}/restore");

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'deleted_at' => null,
        ]);
    }
}
