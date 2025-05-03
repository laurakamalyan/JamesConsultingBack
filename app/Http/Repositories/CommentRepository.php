<?php

namespace App\Http\Repositories;

use App\Http\Contracts\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentRepositoryInterface
{

    /**'
     * @param Comment $comment
     */
    public function __construct(protected Comment $comment) {}

    /**
     * @return Collection
     */
    public function all(): Collection {
        return $this->comment->where('user_id', Auth::user()->id)->
        with('likes')->get();
    }

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment {
        return $this->comment->create($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->comment->destroy($id);
    }

    /**
     * @param int $id
     * @return Comment|null
     */
    public function find(int $id): Comment|null {
        return $this->comment->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool {
        return $this->comment->where('id', $id)->update($data);
    }
}
