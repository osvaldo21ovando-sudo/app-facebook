<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Jobs\MatchEngagementJob;
use Illuminate\Http\Request;

class MatchApprovalController extends Controller
{
    public function __construct()
    {
        // middleware se maneja en rutas
    }

    public function index()
    {
        $pendingMatches = User::where('match_status', 'pending_approval')
            ->with('member')
            ->get();

        $unmatchedUsers = User::where('match_status', 'unmatched')
            ->get();

        $pendingMembers = Member::where('status', 'pending')
            ->get();

        return view('admin.matches.index', compact(
            'pendingMatches',
            'unmatchedUsers',
            'pendingMembers'
        ));
    }

    public function approve(User $user)
    {
        if (!$user->member_id) {
            return back()->with(
                'error',
                'Este usuario no tiene un member asignado.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Evitar conflictos si otro miembro ya tiene ese facebook_id
        |--------------------------------------------------------------------------
        */

        $existingMember = Member::where('facebook_id', $user->facebook_id)
            ->where('id', '!=', $user->member_id)
            ->first();

        if ($existingMember) {
            return back()->with(
                'error',
                'Ese Facebook ID ya está vinculado a otro miembro.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Aprobar usuario
        |--------------------------------------------------------------------------
        */

        $user->update([
            'match_status' => 'approved',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Vincular miembro
        |--------------------------------------------------------------------------
        */

        $user->member->update([
            'facebook_id'     => $user->facebook_id,
            'facebook_name'   => $user->facebook_name,
            'facebook_avatar' => $user->facebook_avatar,
            'status'          => 'linked',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Re-ejecutar matching de interacciones
        |--------------------------------------------------------------------------
        */

        MatchEngagementJob::dispatch();

        return back()->with(
            'success',
            "Match aprobado: {$user->member->name} ↔ {$user->facebook_name}"
        );
    }

    public function reject(User $user)
    {
        $user->update([
            'match_status' => 'rejected',
            'member_id'    => null,
        ]);

        return back()->with(
            'info',
            'Match rechazado.'
        );
    }

    public function assignManually(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'member_id' => 'required|exists:members,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $member = Member::findOrFail($request->member_id);

        /*
        |--------------------------------------------------------------------------
        | Verificar si facebook_id ya está usado
        |--------------------------------------------------------------------------
        */

        $existingMember = Member::where('facebook_id', $user->facebook_id)
            ->where('id', '!=', $member->id)
            ->first();

        if ($existingMember) {
            return back()->with(
                'error',
                'Ese Facebook ID ya está vinculado a otro miembro.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Aprobar match
        |--------------------------------------------------------------------------
        */

        $user->update([
            'member_id'    => $member->id,
            'match_status' => 'approved',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Vincular datos Facebook
        |--------------------------------------------------------------------------
        */

        $member->update([
            'facebook_id'     => $user->facebook_id,
            'facebook_name'   => $user->facebook_name,
            'facebook_avatar' => $user->facebook_avatar,
            'status'          => 'linked',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Re-match de interacciones
        |--------------------------------------------------------------------------
        */

        MatchEngagementJob::dispatch();

        return back()->with(
            'success',
            "Asignación manual: {$member->name} ↔ {$user->facebook_name}"
        );
    }
}