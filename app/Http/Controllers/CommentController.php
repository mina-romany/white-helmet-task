<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Comment\AddCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Requests\Comment\DeleteCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCommentRequest $request)
    {
        return new CommentResource(
            $this->commentService->create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CommentResource(
            $this->commentService->get($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, string $id)
    {
        return new CommentResource(
            $this->commentService->update($id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCommentRequest $request, string $id)
    {
        $this->commentService->delete($id);
        return response()->noContent();
    }

}
