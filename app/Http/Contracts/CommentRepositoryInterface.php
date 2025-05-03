<?php

namespace App\Http\Contracts;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Comment | null;

    public function create(array $data): Comment;

    public function update(array $data, int $id): bool;

    public function delete(int $id): bool;
}
