<?php
namespace App\Services;

use App\Models\Member;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;
use App\Models\PoliticalStructure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EngagementService
{
    public function matchEngagementToMembers(): int
    {
        $linkedMembers = Member::whereNotNull('facebook_id')
            ->where('status', 'linked')
            ->pluck('id', 'facebook_id');

        if ($linkedMembers->isEmpty()) {
            return 0;
        }

        // Reacciones
        Reaction::whereIn('facebook_user_id', $linkedMembers->keys())
            ->get()
            ->each(function ($reaction) use ($linkedMembers) {

                $memberId = $linkedMembers[$reaction->facebook_user_id] ?? null;

                if ($memberId) {
                    $reaction->update([
                        'member_id' => $memberId
                    ]);
                }
            });

        // Comentarios
        Comment::whereIn('facebook_user_id', $linkedMembers->keys())
            ->get()
            ->each(function ($comment) use ($linkedMembers) {

                $memberId = $linkedMembers[$comment->facebook_user_id] ?? null;

                if ($memberId) {
                    $comment->update([
                        'member_id' => $memberId
                    ]);
                }
            });

        $this->recalculateMemberCountsOnPosts();

        return Reaction::whereNotNull('member_id')->count()
            + Comment::whereNotNull('member_id')->count();
    }

    public function recalculateMemberCountsOnPosts(): void
    {
        DB::statement("
            UPDATE posts p
            SET member_reaction_count = (
                SELECT COUNT(*) FROM reactions r
                WHERE r.facebook_post_id = p.facebook_post_id
                AND r.member_id IS NOT NULL
            ),
            member_comment_count = (
                SELECT COUNT(*) FROM comments c
                WHERE c.facebook_post_id = p.facebook_post_id
                AND c.member_id IS NOT NULL
            )
        ");
    }

    public function whoInteracted(?string $postId = null): Collection
    {
        return Member::where('status', 'linked')
            ->with('politicalStructure')
            ->get()
            ->filter(function ($member) use ($postId) {
                $hasReaction = $member->reactions()
                    ->when($postId, fn($q) => $q->where('facebook_post_id', $postId))
                    ->exists();
                $hasComment = $member->comments()
                    ->when($postId, fn($q) => $q->where('facebook_post_id', $postId))
                    ->exists();
                return $hasReaction || $hasComment;
            })
            ->map(function ($member) use ($postId) {
                $reactions = $member->reactions()
                    ->when($postId, fn($q) => $q->where('facebook_post_id', $postId))
                    ->count();
                $comments = $member->comments()
                    ->when($postId, fn($q) => $q->where('facebook_post_id', $postId))
                    ->count();
                return [
                    'member'              => $member,
                    'reactions'           => $reactions,
                    'comments'            => $comments,
                    'total_interactions'  => $reactions + $comments,
                    'political_structure' => $member->politicalStructure?->name,
                ];
            })
            ->sortByDesc('total_interactions')
            ->values();
    }

    public function whoDidNotInteract(?string $postId = null): Collection
    {
        return Member::where('status', 'linked')
            ->with('politicalStructure')
            ->get()
            ->filter(function ($member) use ($postId) {
                $hasReaction = $member->reactions()
                    ->when($postId, fn($q) => $q->where('facebook_post_id', $postId))
                    ->exists();
                $hasComment = $member->comments()
                    ->when($postId, fn($q) => $q->where('facebook_post_id', $postId))
                    ->exists();
                return !$hasReaction && !$hasComment;
            })
            ->map(fn($m) => [
                'member'              => $m,
                'political_structure' => $m->politicalStructure?->name,
            ])
            ->values();
    }

    public function topPostsByTeamSupport(int $limit = 10): Collection
    {
        return Post::orderByRaw('(reaction_count + comment_count) DESC')
            ->limit($limit)
            ->get()
            ->map(fn($post) => [
                'post'              => $post,
                'support_score'     => $post->reaction_count + $post->comment_count,
                'member_reactions'  => $post->member_reaction_count,
                'member_comments'   => $post->member_comment_count,
                'total_reactions'   => $post->reaction_count,
                'total_comments'    => $post->comment_count,
            ]);
    }

    public function memberActivityRanking(int $limit = 20): Collection
    {
        return Member::where('status', 'linked')
            ->with('politicalStructure')
            ->withCount(['reactions', 'comments'])
            ->get()
            ->map(fn($m) => [
                'member'              => $m,
                'reactions_count'     => $m->reactions_count,
                'comments_count'      => $m->comments_count,
                'total'               => $m->reactions_count + $m->comments_count,
                'posts_participated'  => count($m->interactedPostIds()),
                'political_structure' => $m->politicalStructure?->name,
            ])
            ->sortByDesc('total')
            ->take($limit)
            ->values();
    }

    public function structureParticipationRanking(): Collection
    {
        return PoliticalStructure::with('members')->get()
            ->map(function ($structure) {
                $memberIds = $structure->members()->where('status', 'linked')->pluck('id');
                $reactions = Reaction::whereIn('member_id', $memberIds)->count();
                $comments  = Comment::whereIn('member_id', $memberIds)->count();
                $total     = $memberIds->count();
                return [
                    'structure'          => $structure,
                    'total_members'      => $total,
                    'total_reactions'    => $reactions,
                    'total_comments'     => $comments,
                    'total_interactions' => $reactions + $comments,
                    'avg_per_member'     => $total > 0
                        ? round(($reactions + $comments) / $total, 2)
                        : 0,
                ];
            })
            ->sortByDesc('total_interactions')
            ->values();
    }

    public function dashboardSummary(): array
    {
        $totalMembers        = Member::where('status', 'linked')->count();
        $pendingMembers      = Member::where('status', 'pending')->count();
        $totalPosts          = Post::count();
        $totalReactions      = Reaction::whereNotNull('member_id')->count();
        $totalComments       = Comment::whereNotNull('member_id')->count();
        $membersWhoInteracted = Member::where('status', 'linked')
            ->where(function ($q) {
                $q->whereHas('reactions')->orWhereHas('comments');
            })->count();

        $participationRate = $totalMembers > 0
            ? round(($membersWhoInteracted / $totalMembers) * 100, 1)
            : 0;

        return [
            'total_members'        => $totalMembers,
            'pending_members'      => $pendingMembers,
            'members_interacted'   => $membersWhoInteracted,
            'members_silent'       => $totalMembers - $membersWhoInteracted,
            'participation_rate'   => $participationRate,
            'total_posts_tracked'  => $totalPosts,
            'total_team_reactions' => $totalReactions,
            'total_team_comments'  => $totalComments,
            'total_interactions'   => $totalReactions + $totalComments,
        ];
    }
}