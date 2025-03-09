<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CommentAddedNotification;

class CommentService
{
    public function get(string $id): Comment
    {
        return Comment::findOrFail($id);
    }

    public function create(array $validated): Comment
    {
        $validated['user_id'] = Auth::user()->id;
        $comment = Comment::create($validated);

        $this->notify($comment);

        return $comment;
    }

    public function update(string $id, array $validated): Comment
    {
        $comment = Comment::findOrFail($id);
        $comment->update($validated);
        return $comment;
    }

    public function delete(string $id): void
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }

    public function notify(Comment $comment): void
    {
        $task = $comment->task;
        $user = Auth::user();

           // Notify task author if it's a different user
           if ($task->user_id !== $user->id) {
            $task->user->notify(
                new CommentAddedNotification($comment, $task, $user)
            );
        }
    }
}
