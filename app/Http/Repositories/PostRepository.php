<?php

namespace App\Http\Repositories;

use App\Http\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{

    /**
     * @param Post $post
     */
    public function __construct(protected Post $post) {}

    /**
     * @return Collection
     */
    public function all(): Collection {
        return $this->post->
        with(['comments.children', 'likes'])->get();
    }

    /**
     * @param array $data
     * @return Post
     */
    public function create(array $data): Post {
        return $this->post->create($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->post->destroy($id);
    }

    /**
     * @param int $id
     * @return Post|null
     */
    public function find(int $id): Post | null {
        return $this->post->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool {
        return $this->post->where('id', $id)->update($data);
    }
}
