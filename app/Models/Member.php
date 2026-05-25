<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'name', 'facebook_id', 'facebook_name', 'facebook_avatar',
        'phone', 'position', 'political_structure_id', 'status',
    ];

    public function politicalStructure(): BelongsTo
    {
        return $this->belongsTo(PoliticalStructure::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function scopeLinked($query)
    {
        return $query->where('status', 'linked');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function isLinked(): bool
    {
        return $this->status === 'linked';
    }

    public function totalInteractions(): int
    {
        return $this->reactions()->count() + $this->comments()->count();
    }

    public function interactedPostIds(): array
    {
        $fromReactions = $this->reactions()->pluck('facebook_post_id')->toArray();
        $fromComments  = $this->comments()->pluck('facebook_post_id')->toArray();
        return array_unique(array_merge($fromReactions, $fromComments));
    }
}