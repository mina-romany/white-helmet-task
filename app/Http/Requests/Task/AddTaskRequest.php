<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class AddTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'due_date' => 'required|date|after:today',
        ];
    }
}
