<?php

namespace App\Http\Repositories;

use App\Http\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface {
    /**
     * @param User $user
     */
    public function __construct(protected User $user) { }

    /**
     * @return Collection
     */
    public function all() : Collection {
        return $this->user->where('id', Auth::user()->id)->
        with('posts')->with('posts.comments')->get();
    }

    /**
     * @param array $data
     * @return User|null
     */
    public function find(array $data) : User | null {
        return $this->user->where($data)->first();
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data) : User {
        return $this->user->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id) : bool {
        return $this->user->where('id', $id)->update($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool {
        return $this->user->destroy($id);
    }
}
