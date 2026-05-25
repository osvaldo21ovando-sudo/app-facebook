<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{   
    protected $fillable = [
        'facebook_post_id', 'facebook_user_id', 'facebook_user_name',
        'type', 'member_id', 'reacted_at',
    ];

    protected $casts = ['reacted_at' => 'datetime'];

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