<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'facebook_post_id', 'message', 'story', 'type', 'permalink',
        'full_picture', 'comment_count', 'reaction_count', 'share_count',
        'member_reaction_count', 'member_comment_count', 'published_at', 'last_synced_at',
    ];

    protected $casts = [
        'published_at'   => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'facebook_post_id', 'facebook_post_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class, 'facebook_post_id', 'facebook_post_id');
    }

    public function engagedMemberIds(): array
    {
        $fromReactions = $this->reactions()->whereNotNull('member_id')->pluck('member_id')->toArray();
        $fromComments  = $this->comments()->whereNotNull('member_id')->pluck('member_id')->toArray();
        return array_unique(array_merge($fromReactions, $fromComments));
    }

    public function supportScore(): int
    {
        return $this->member_reaction_count + ($this->member_comment_count * 2);
    }
}