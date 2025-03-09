<?php

namespace Tests\Unit\Service;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TaskService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->service = new TaskService();
    }

    public function test_create_task()
    {
        $task = $this->service->create([
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'PENDING',
            'assignee_id' => $this->user->id,
            'due_date' => '2025-04-10'
        ]);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->title);
    }

    public function test_get_all_tasks()
    {
        Task::factory(3)->create(['assignee_id' => $this->user->id]);

        $tasks = $this->service->getAll($this->user);
        $this->assertCount(3, $tasks);
    }
}
