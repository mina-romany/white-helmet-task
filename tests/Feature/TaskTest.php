<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_create_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'PENDING',
            'assignee_id' => $this->user->id,
            'due_date' => '2025-04-10'
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.title', 'Test Task');
    }

    public function test_get_all_tasks()
    {
        Task::factory(3)->create(['assignee_id' => $this->user->id]);

        $response = $this->getJson('/api/tasks');
        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_update_task()
    {
        $task = Task::factory()->create(['assignee_id' => $this->user->id]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'description' => 'Test Description',
            'status' => 'PENDING',
            'assignee_id' => $this->user->id,
            'due_date' => '2025-04-10'
        ]);

        $response->assertOk()
            ->assertJsonPath('data.title', 'Updated Title');
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create(['assignee_id' => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertNoContent();
    }
}
