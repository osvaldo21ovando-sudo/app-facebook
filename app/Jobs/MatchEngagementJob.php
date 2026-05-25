<?php
namespace App\Jobs;

use App\Models\SyncLog;
use App\Services\EngagementService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MatchEngagementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(EngagementService $engagement): void
    {
        $log = SyncLog::create([
            'type'       => 'matching',
            'status'     => 'running',
            'started_at' => now(),
        ]);

        try {
            $matched = $engagement->matchEngagementToMembers();

            $log->update([
                'status'         => 'success',
                'records_synced' => $matched,
                'message'        => "{$matched} interacciones vinculadas a miembros",
                'finished_at'    => now(),
            ]);

        } catch (\Throwable $e) {
            Log::error('MatchEngagementJob failed', ['error' => $e->getMessage()]);
            $log->update([
                'status'      => 'error',
                'message'     => $e->getMessage(),
                'finished_at' => now(),
            ]);
            throw $e;
        }
    }
}   