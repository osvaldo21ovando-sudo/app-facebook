<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoliticalStructure extends Model
{
    protected $fillable = ['name', 'type', 'parent_id', 'color'];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PoliticalStructure::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(PoliticalStructure::class, 'parent_id');
    }

    public function totalInteractions(): int
    {
        $memberIds = $this->members()->pluck('id');
        $reactions = Reaction::whereIn('member_id', $memberIds)->count();
        $comments  = Comment::whereIn('member_id', $memberIds)->count();
        return $reactions + $comments;
    }
}