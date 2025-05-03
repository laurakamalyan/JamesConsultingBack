<?php

namespace App\Http\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Post | null;

    public function create(array $data): Post;

    public function update(array $data, int $id): bool;

    public function delete(int $id): bool;
}
