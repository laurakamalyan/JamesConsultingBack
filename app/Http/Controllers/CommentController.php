<?php

namespace App\Http\Controllers;

use App\Http\Contracts\CommentRepositoryInterface;
use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(protected CommentRepositoryInterface $commentRepository){}

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        $comments = $this->commentRepository->all();
        return response()->json($comments);
    }

    /**
     * @param CommentCreateRequest $request
     * @return JsonResponse
     */
    public function create(CommentCreateRequest $request) : JsonResponse {
        try {
            $request->validated();
            DB::beginTransaction();
            $comment = $this->commentRepository->create([
                'text' => $request->text,
                'post_id' => $request->post_id,
                'user_id' => Auth::user()->id,
                'parent_comment_id' => $request->parent_comment_id,
            ]);

            DB::commit();
            return response()->json($comment);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Error! Comment could not be created.']);
        }
    }

    /**
     * @param CommentUpdateRequest $request
     * @param int $comment_id
     * @return JsonResponse
     */
    public function update(CommentUpdateRequest $request, int $comment_id) : JsonResponse {
        $request->validated();
        $comment = $this->commentRepository->find($comment_id);

        $this->commentRepository->update([
            'text' => $request->input('text') ?? $comment->title,
        ], $comment_id);

        return response()->json(['message' => 'Comment updated successfully.']);
    }

    /**
     * @param int $comment_id
     * @return JsonResponse
     */
    public function delete(int $comment_id) : JsonResponse {
        $this->commentRepository->delete($comment_id);
        return response()->json(['message' => 'Comment deleted successfully.']);
    }

    /**
     * @param $comment_id
     * @return JsonResponse
     */
    public function createCommentLike($comment_id) : JsonResponse {
        $comment = Comment::find($comment_id);
        $comment->likes()->create([
            'user_id' => Auth::user()->id,
        ]);
        return response()->json('Comment liked!');
    }
}
