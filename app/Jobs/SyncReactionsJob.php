<?php
namespace App\Jobs;

use App\Models\Post;
use App\Models\Reaction;
use App\Models\SyncLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncReactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(): void
    {
        $log = SyncLog::create([
            'type'       => 'reactions',
            'status'     => 'running',
            'started_at' => now(),
        ]);

        try {
            $pageToken = config('services.facebook.page_token');
            $baseUrl   = 'https://graph.facebook.com/v25.0';
            $synced    = 0;

            $posts = Post::all();

            foreach ($posts as $post) {
                $response = Http::get("{$baseUrl}/{$post->facebook_post_id}/reactions", [
                'access_token' => $pageToken,
                'fields'       => 'id,name,type',
                'summary'      => 'true',
                'limit'        => 100,
            ]);

                if ($response->failed()) {
                    Log::error('SyncReactionsJob error', ['post' => $post->facebook_post_id, 'body' => $response->body()]);
                    continue;
                }

                $reactions = $response->json('data', []);
                $totalReactions = $response->json('summary.total_count', 0);

                foreach ($reactions as $r) {
                    Reaction::updateOrCreate(
                        [
                            'facebook_post_id' => $post->facebook_post_id,
                            'facebook_user_id' => $r['id']
                        ],
                        [
                            'facebook_user_name' => $r['name'],
                            'type' => $r['type'],
                            'reacted_at' => now()
                        ]
                    );

                    $synced++;
                }

                $post->update([
                    'reaction_count' => $totalReactions
                ]);
            }

            $log->update(['status' => 'success', 'records_synced' => $synced, 'finished_at' => now()]);
            MatchEngagementJob::dispatch();

        } catch (\Throwable $e) {
            Log::error('SyncReactionsJob failed', ['error' => $e->getMessage()]);
            $log->update(['status' => 'error', 'message' => $e->getMessage(), 'finished_at' => now()]);
            throw $e;
        }
    }
}