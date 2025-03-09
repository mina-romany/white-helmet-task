<?php

namespace Tests\Unit\Service;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CommentService;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_belongs_to_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['assignee_id' => $user->id]);

        $this->assertInstanceOf(User::class, $task->user);
        $this->assertEquals($user->id, $task->user->id);
    }

    public function test_task_has_comments()
    {
        $task = Task::factory()->create();
        $comment = $task->comments()->create([
            'task_id' => $task->id,
            'body' => 'Test Comment',
            'user_id' => User::factory()->create()->id
        ]);

        $this->assertTrue($task->comments->contains($comment));
    }
}
