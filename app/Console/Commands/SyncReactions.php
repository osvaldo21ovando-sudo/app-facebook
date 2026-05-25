<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\Comment;

class SyncReactions extends Command
{
    protected $signature = 'fb:sync-engagement';
    protected $description = 'Sincronizar reacciones y comentarios';

    public function handle()
    {
        $pageToken = config('services.facebook.page_token');
        $baseUrl   = 'https://graph.facebook.com/v25.0';
        $posts     = Post::all();

        $this->info("Posts a procesar: " . $posts->count());

        foreach ($posts as $post) {
            $this->line("\nPost: " . substr($post->message ?? 'Sin texto', 0, 50));

            // ── Reacciones ──────────────────────────────────

            // Total real (incluye usuarios no registrados)
            $summaryResponse = Http::get("{$baseUrl}/{$post->facebook_post_id}/reactions", [
                'access_token' => $pageToken,
                'summary'      => 'true',
                'limit'        => 0,
            ]);
            $totalReactions = $summaryResponse->successful()
                ? $summaryResponse->json('summary.total_count', 0)
                : 0;

            // Detalle de quién reaccionó (usuarios que autorizaron la app)
            $response = Http::get("{$baseUrl}/{$post->facebook_post_id}/reactions", [
                'access_token' => $pageToken,
                'fields'       => 'id,name,type',
                'limit'        => 100,
            ]);

            if ($response->successful()) {
                $reactions = $response->json('data', []);

                // IDs actuales desde Facebook
                $currentIds = collect($reactions)->pluck('id')->toArray();

                // Eliminar reacciones que ya no existen en Facebook
                Reaction::where('facebook_post_id', $post->facebook_post_id)
                    ->whereNotIn('facebook_user_id', $currentIds)
                    ->delete();

                // Insertar o actualizar las que sí existen
                foreach ($reactions as $r) {
                    Reaction::updateOrCreate(
                        [
                            'facebook_post_id' => $post->facebook_post_id,
                            'facebook_user_id' => $r['id'],
                        ],
                        [
                            'facebook_user_name' => $r['name'],
                            'type'               => $r['type'],
                            'reacted_at'         => now(),
                        ]
                    );
                }

                $post->update(['reaction_count' => $totalReactions]);
                $this->line("  ✓ Reacciones en app: " . count($reactions) . " / Total FB: {$totalReactions}");
            } else {
                $this->error("  Error reacciones: " . $response->body());
            }

            // ── Comentarios ─────────────────────────────────

            // Total real de comentarios
            $summaryComments = Http::get("{$baseUrl}/{$post->facebook_post_id}/comments", [
                'access_token' => $pageToken,
                'summary'      => 'true',
                'limit'        => 0,
            ]);
            $totalComments = $summaryComments->successful()
                ? $summaryComments->json('summary.total_count', 0)
                : 0;

            $response = Http::get("{$baseUrl}/{$post->facebook_post_id}/comments", [
                'access_token' => $pageToken,
                'fields'       => 'id,from,message,created_time',
                'limit'        => 100,
            ]);

            if ($response->successful()) {
                $comments = $response->json('data', []);

                // IDs actuales desde Facebook
                $currentCommentIds = collect($comments)->pluck('id')->toArray();

                // Eliminar comentarios que ya no existen en Facebook
                Comment::where('facebook_post_id', $post->facebook_post_id)
                    ->whereNotIn('facebook_comment_id', $currentCommentIds)
                    ->delete();

                // Insertar o actualizar los que sí existen
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
                            'commented_at'       => \Carbon\Carbon::parse($c['created_time']),
                        ]
                    );
                }

                $post->update(['comment_count' => $totalComments]);
                $this->line("  ✓ Comentarios guardados: " . count($comments) . " / Total FB: {$totalComments}");
            } else {
                $this->error("  Error comentarios: " . $response->body());
            }
        }

        // Recalcular contadores de miembros en posts
        $this->info("\nRecalculando contadores de miembros...");
        app(\App\Services\EngagementService::class)->recalculateMemberCountsOnPosts();

        $this->info("Total reacciones en DB: " . Reaction::count());
        $this->info("Total comentarios en DB: " . Comment::count());
        $this->info("\n✅ Sincronización completa.");
    }
}