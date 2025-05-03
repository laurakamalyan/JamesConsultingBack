<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function users() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function posts() : BelongsTo {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return MorphMany
     */
    public function likes(): MorphMany {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany {
        return $this->hasMany(self::class, 'parent_comment_id');
    }
}
