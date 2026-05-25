<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookService
{
    protected string $pageId;
    protected string $pageToken;
    protected string $baseUrl = 'https://graph.facebook.com/v25.0';

    public function __construct()
    {
        $this->pageId    = config('services.facebook.page_id');
        $this->pageToken = config('services.facebook.page_token');
    }

    public function getPagePosts(int $limit = 25, ?string $after = null): array
        {
            $fields = implode(',', [
                'id', 'message', 'story', 'type',
                'permalink_url', 'shares', 'created_time',
            ]);

            $params = [
                'access_token' => $this->pageToken,
                'fields'       => $fields,
                'limit'        => $limit,
            ];

            if ($after) {
                $params['after'] = $after;
            }

            $response = Http::get("{$this->baseUrl}/{$this->pageId}/posts", $params);

            if ($response->failed()) {
                Log::error('FB getPagePosts error', ['body' => $response->body()]);
                return [];
            }

            return $response->json('data', []);
        }

    public function getPostReactions(string $postId): array
    {
        $reactions = [];
        $url = "{$this->baseUrl}/{$postId}/reactions";
        $params = [
            'access_token' => $this->pageToken,
            'fields'       => 'id,name,type',
            'limit'        => 100,
        ];

        do {
            $response = Http::get($url, $params);

            if ($response->failed()) {
                Log::error('FB getPostReactions error', [
                    'post_id' => $postId,
                    'body'    => $response->body(),
                ]);
                break;
            }

            $data      = $response->json();
            $reactions = array_merge($reactions, $data['data'] ?? []);

            $nextUrl = $data['paging']['next'] ?? null;
            if ($nextUrl) {
                $url    = $nextUrl;
                $params = [];
            }

        } while ($nextUrl);

        return $reactions;
    }

    public function getPostReactionCount(string $postId): int
    {
        $response = Http::get("{$this->baseUrl}/{$postId}/reactions", [
            'access_token' => $this->pageToken,
            'summary'      => 'true',
            'limit'        => 0,
        ]);

        if ($response->failed()) return 0;

        return $response->json('summary.total_count', 0);
    }

    public function getPostComments(string $postId): array
    {
        $comments = [];
        $url = "{$this->baseUrl}/{$postId}/comments";
        $params = [
            'access_token' => $this->pageToken,
            'fields'       => 'id,from,message,created_time',
            'limit'        => 100,
            'filter'       => 'stream',
        ];

        do {
            $response = Http::get($url, $params);

            if ($response->failed()) {
                Log::error('FB getPostComments error', [
                    'post_id' => $postId,
                    'body'    => $response->body(),
                ]);
                break;
            }

            $data     = $response->json();
            $comments = array_merge($comments, $data['data'] ?? []);

            $nextUrl = $data['paging']['next'] ?? null;
            if ($nextUrl) {
                $url    = $nextUrl;
                $params = [];
            }

        } while ($nextUrl);

        return $comments;
    }

    public function getUserProfile(string $userToken): ?array
    {
        $response = Http::get("{$this->baseUrl}/me", [
            'access_token' => $userToken,
            'fields'       => 'id,name,email,picture.type(large)',
        ]);

        if ($response->failed()) {
            Log::error('FB getUserProfile error', ['body' => $response->body()]);
            return null;
        }

        return $response->json();
    }

    public function exchangeForLongLivedToken(string $shortToken): ?array
    {
        $response = Http::get("{$this->baseUrl}/oauth/access_token", [
            'grant_type'        => 'fb_exchange_token',
            'client_id'         => config('services.facebook.client_id'),
            'client_secret'     => config('services.facebook.client_secret'),
            'fb_exchange_token' => $shortToken,
        ]);

        if ($response->failed()) {
            Log::error('FB token exchange error', ['body' => $response->body()]);
            return null;
        }

        return $response->json();
    }

    public function verifyPageToken(): bool
    {
        $response = Http::get("{$this->baseUrl}/{$this->pageId}", [
            'access_token' => $this->pageToken,
            'fields'       => 'id,name',
        ]);

        return $response->successful();
    }
}