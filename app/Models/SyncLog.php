<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    protected $fillable = [
        'type', 'status', 'records_synced', 'message', 'meta', 'started_at', 'finished_at',
    ];

    protected $casts = [
        'meta'        => 'array',
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function duration(): ?string
    {
        if (!$this->finished_at) return null;
        $seconds = $this->started_at->diffInSeconds($this->finished_at);
        return "{$seconds}s";
    }
}