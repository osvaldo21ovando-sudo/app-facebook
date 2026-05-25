<?php
namespace App\Jobs;

use App\Models\Post;
use App\Models\Comment;
use App\Models\SyncLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncCommentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(): void
    {
        $log = SyncLog::create([
            'type'       => 'comments',
            'status'     => 'running',
            'started_at' => now(),
        ]);

        try {
            $pageToken = config('services.facebook.page_token');
            $baseUrl   = 'https://graph.facebook.com/v25.0';
            $synced    = 0;

            $posts = Post::all();

            foreach ($posts as $post) {
                $response = Http::get("{$baseUrl}/{$post->facebook_post_id}/comments", [
                    'access_token' => $pageToken,
                    'fields'       => 'id,from,message,created_time',
                    'summary' => 'true',
                    'limit'        => 100,
                ]);

                if ($response->failed()) {
                    Log::error('SyncCommentsJob error', ['post' => $post->facebook_post_id, 'body' => $response->body()]);
                    continue;
                }

                $comments = $response->json('data', []);

                foreach ($comments as $c) {
                    $from = $c['from'] ?? null;
                    if (!$from) continue;

                    Comment::updateOrCreate(
                        ['facebook_comment_id' => $c['id']],
                        [
                            'facebook_post_id'   => $post->facebook_post_id,
                            'facebook_user_id'   => $from['id'],
                            'facebook_user_name' => $from['name'] ?? null,
                            'message'            => $c['message'] ?? null,
                            'commented_at'       => Carbon::parse($c['created_time']),
                        ]
                    );
                    $synced++;
                }

                $totalComments = $response->json('summary.total_count', 0);

                $post->update([
                    'comment_count' => $totalComments
                ]);
            }

            $log->update(['status' => 'success', 'records_synced' => $synced, 'finished_at' => now()]);

        } catch (\Throwable $e) {
            Log::error('SyncCommentsJob failed', ['error' => $e->getMessage()]);
            $log->update(['status' => 'error', 'message' => $e->getMessage(), 'finished_at' => now()]);
            throw $e;
        }
    }
}