<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Task\AddTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\DeleteTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TaskResource::collection($this->taskService->getAll());
    }

    public function mytasks()
    {
        return TaskResource::collection($this->taskService->mytasks());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(AddTaskRequest $request)
    {
        return new TaskResource(
            $this->taskService->create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TaskResource(
            $this->taskService->get($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        return new TaskResource(
            $this->taskService->update($id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteTaskRequest $request, string $id)
    {
        $request->validated();
        $this->taskService->delete($id);
        return response()->noContent();
    }
}
