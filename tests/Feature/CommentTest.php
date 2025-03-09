<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;


class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
        $this->task = Task::factory()->create(['assignee_id' => $this->user->id]);
    }

    public function test_create_comment()
    {
        $response = $this->postJson("/api/comments", [
            'task_id' => $this->task->id,
            'body' => 'Test Comment'
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.body', 'Test Comment');
    }

    public function test_update_comment()
    {
        $comment = Comment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id
        ]);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'body' => 'Updated Comment'
        ]);

        $response->assertOk()
            ->assertJsonPath('data.body', 'Updated Comment');
    }

    public function test_delete_comment()
    {
        $comment = Comment::factory()->create([
            'task_id' => $this->task->id,
            'user_id' => $this->user->id
        ]);

        $response = $this->deleteJson("/api/comments/{$comment->id}");
        $response->assertNoContent();
    }
}
