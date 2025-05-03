<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];

    /**
     * @return HasMany
     */
    public function posts() : HasMany {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany
     */
    public function comments() : HasMany {
        return $this->hasMany(Comment::class);
    }
}
