<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    public function getAll(): Collection
    {
        $cacheKey = 'tasks';
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            $data = Task::with('comments', 'user')->latest()->get();
            Cache::put($cacheKey, $data, 600);
            return $data;
        }
    }

    public function myTasks() : Collection
    {
        return Task::where('assignee_id', Auth::user()->id)
                    ->with('comments', 'user')->latest()->get();
    }

    public function create(array $validated): Task
    {
        return Task::create($validated);
    }

    public function get(string $id): Task
    {
        $task = Task::findOrFail($id);
        return $task->load('comments');
    }

    public function update(string $id, array $validated): Task
    {
        $task = Task::findOrFail($id);
        $task->update($validated);
        return $task;
    }

    public function delete(string $id): void
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}
