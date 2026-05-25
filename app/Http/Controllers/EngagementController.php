<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\EngagementService;
use Illuminate\Http\Request;

class EngagementController extends Controller
{
    public function __construct(
        private EngagementService $engagement
    ) {
        // middleware se maneja en las rutas
    }

    public function dashboard()
    {
        $summary          = $this->engagement->dashboardSummary();
        $topPosts         = $this->engagement->topPostsByTeamSupport(5);
        $topMembers       = $this->engagement->memberActivityRanking(10);
        $structureRanking = $this->engagement->structureParticipationRanking();
        $whoNotInteracted = $this->engagement->whoDidNotInteract();

        return view('dashboard', compact(
            'summary', 'topPosts', 'topMembers', 'structureRanking', 'whoNotInteracted'
        ));
    }

    public function postDetail(Post $post)
    {
        $interacted    = $this->engagement->whoInteracted($post->facebook_post_id);
        $notInteracted = $this->engagement->whoDidNotInteract($post->facebook_post_id);

        return view('posts.detail', compact('post', 'interacted', 'notInteracted'));
    }

    public function apiSummary()
    {
        return response()->json($this->engagement->dashboardSummary());
    }

    public function apiMemberRanking()
    {
        return response()->json($this->engagement->memberActivityRanking(20));
    }

    public function apiStructureRanking()
    {
        return response()->json($this->engagement->structureParticipationRanking());
    }
}