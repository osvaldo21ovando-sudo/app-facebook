<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'facebook_comment_id', 'facebook_post_id', 'facebook_user_id',
        'facebook_user_name', 'message', 'member_id', 'commented_at',
    ];

    protected $casts = ['commented_at' => 'datetime'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'facebook_post_id', 'facebook_post_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function isFromTeamMember(): bool
    {
        return $this->member_id !== null;
    }
}   