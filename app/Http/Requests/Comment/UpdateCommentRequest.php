<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\CommentService;

class UpdateCommentRequest extends FormRequest
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        parent::__construct();
        $this->commentService = $commentService;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->id == $this->commentService->get($this->id)->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => 'bail|required|string',
        ];
    }
}
