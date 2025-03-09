<?php

namespace App\Http\Requests\Task;
use Illuminate\Support\Facades\Auth;
use App\Services\TaskService;
use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Status;

class UpdateTaskRequest extends FormRequest
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->id == $this->taskService->get($this->id)->assignee_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'in:PENDING,INPROGRESS,COMPLETED',
            'assignee_id' => 'bail|required|numeric|exists:users,id',
            'title' => 'bail|required|string|max:100',
            'description' => 'bail|required|string|max:500',
            'due_date' => 'bail|required|date|after:today',
        ];
    }
}
