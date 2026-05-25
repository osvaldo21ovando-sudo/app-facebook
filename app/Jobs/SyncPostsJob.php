<?php
namespace App\Jobs;

use App\Models\Post;
use App\Models\SyncLog;
use App\Services\FacebookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SyncPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(FacebookService $fb): void
    {
        $log = SyncLog::create([
            'type'       => 'posts',
            'status'     => 'running',
            'started_at' => now(),
        ]);

        try {
            $synced = 0;

            $posts = $fb->getPagePosts(25);

            Log::info('SyncPostsJob - Posts recibidos: ' . count($posts));

            foreach ($posts as $fbPost) {
                Post::updateOrCreate(
                    ['facebook_post_id' => $fbPost['id']],
                    [
                        'message'        => $fbPost['message'] ?? null,
                        'story'          => $fbPost['story'] ?? null,
                        'type'           => $fbPost['type'] ?? null,
                        'permalink'      => $fbPost['permalink_url'] ?? null,
                        'share_count'    => $fbPost['shares']['count'] ?? 0,
                        'published_at'   => Carbon::parse($fbPost['created_time']),
                        'last_synced_at' => now(),
                    ]
                );
                $synced++;
            }

            $log->update([
                'status'         => 'success',
                'records_synced' => $synced,
                'finished_at'    => now(),
            ]);

            SyncCommentsJob::dispatch();
            SyncReactionsJob::dispatch();

        } catch (\Throwable $e) {
            Log::error('SyncPostsJob failed', ['error' => $e->getMessage()]);
            $log->update([
                'status'      => 'error',
                'message'     => $e->getMessage(),
                'finished_at' => now(),
            ]);
            throw $e;
        }
    }
}