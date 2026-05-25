<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'facebook_id', 'facebook_name', 'facebook_avatar',
        'facebook_token', 'facebook_token_long', 'token_expires_at',
        'role', 'member_id', 'match_status',
    ];

    protected $hidden = [
        'password', 'remember_token', 'facebook_token', 'facebook_token_long'
    ];

    protected $casts = ['token_expires_at' => 'datetime'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isMember(): bool { return $this->role === 'member'; }
    public function isMatched(): bool { return $this->match_status === 'approved'; }
}