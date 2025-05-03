<?php

namespace App\Http\Controllers;

use App\Http\Contracts\PostRepositoryInterface;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(protected PostRepositoryInterface $postRepository){}

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        $posts = $this->postRepository->all();
        return response()->json($posts);
    }

    /**
     * @param PostCreateRequest $request
     * @return JsonResponse
     */
    public function create(PostCreateRequest $request) : JsonResponse {
        try {
            $request->validated();
            DB::beginTransaction();
            $posts = $this->postRepository->create([
                'title' => $request->title,
                'body' => $request->body,
                'user_id' => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json($posts);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Error! Unable to create post.']);
        }
    }

    /**
     * @param PostUpdateRequest $request
     * @param int $post_id
     * @return JsonResponse
     */
    public function update(PostUpdateRequest $request, int $post_id) : JsonResponse {
        $request->validated();
        $post = $this->postRepository->find($post_id);

        $this->postRepository->update([
            'title' => $request->input('title') ?? $post->title,
            'body' => $request->input('body') ?? $post->body,
        ], $post_id);

        return response()->json(['message' => 'Post updated successfully.']);
    }

    /**
     * @param int $post_id
     * @return JsonResponse
     */
    public function delete(int $post_id) : JsonResponse {
        $this->postRepository->delete($post_id);
        return response()->json(['message' => 'Post deleted successfully.']);
    }

    /**
     * @param $post_id
     * @return JsonResponse
     */
    public function createPostLike($post_id) : JsonResponse {
        $post = Post::find($post_id);
        $post->likes()->create([
            'user_id' => Auth::user()->id,
        ]);
        return response()->json('Post liked!');
    }
}
