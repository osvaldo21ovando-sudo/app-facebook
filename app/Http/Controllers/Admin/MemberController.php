<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PoliticalStructure;
use App\Models\Reaction;
use App\Models\Comment;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        // middleware se maneja en rutas
    }

    public function index(Request $request)
    {
        $members = Member::with('politicalStructure')
            ->when($request->status, fn($q) =>
                $q->where('status', $request->status)
            )
            ->when($request->structure, fn($q) =>
                $q->where('political_structure_id', $request->structure)
            )
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            )
            ->withCount(['reactions', 'comments'])
            ->orderBy('name')
            ->paginate(25);

        $structures = PoliticalStructure::all();

        return view('admin.members.index', compact(
            'members',
            'structures'
        ));
    }

    public function create()
    {
        $structures = PoliticalStructure::all();

        return view('admin.members.create', compact(
            'structures'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'phone'                  => 'nullable|string|max:20',
            'position'               => 'nullable|string|max:100',
            'political_structure_id' => 'nullable|exists:political_structures,id',
            'facebook_id'            => 'nullable|string|unique:members,facebook_id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Si el admin ya capturó el facebook_id
        | el miembro ya puede quedar vinculado automáticamente.
        |--------------------------------------------------------------------------
        */

        $status = !empty($validated['facebook_id'])
            ? 'linked'
            : 'pending';

        Member::create(array_merge(
            $validated,
            [
                'status' => $status,
            ]
        ));

        return redirect()
            ->route('admin.members.index')
            ->with(
                'success',
                'Miembro capturado correctamente.'
            );
    }

    public function edit(Member $member)
    {
        $structures = PoliticalStructure::all();

        return view('admin.members.edit', compact(
            'member',
            'structures'
        ));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'phone'                  => 'nullable|string|max:20',
            'position'               => 'nullable|string|max:100',
            'political_structure_id' => 'nullable|exists:political_structures,id',
            'facebook_id'            => "nullable|string|unique:members,facebook_id,{$member->id}",
            'status'                 => 'required|in:pending,linked,inactive',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Si se agrega facebook_id manualmente
        | automáticamente queda linked.
        |--------------------------------------------------------------------------
        */

        if (
            empty($member->facebook_id) &&
            !empty($validated['facebook_id'])
        ) {
            $validated['status'] = 'linked';
        }

        $member->update($validated);

        return redirect()
            ->route('admin.members.index')
            ->with(
                'success',
                'Miembro actualizado.'
            );
    }

    public function linkFacebook(Request $request, Member $member)
    {
        $request->validate([
            'facebook_id'   => 'required|string|unique:members,facebook_id,' . $member->id,
            'facebook_name' => 'nullable|string',
        ]);

        $member->update([
            'facebook_id'   => $request->facebook_id,
            'facebook_name' => $request->facebook_name ?? $member->name,
            'status'        => 'linked',
        ]);

        return back()->with(
            'success',
            "Miembro vinculado con Facebook ID: {$request->facebook_id}"
        );
    }

    public function show(Member $member)
    {
        return redirect()->route('admin.members.index');
    }

    public function destroy(Member $member)
    {
        /*
        |--------------------------------------------------------------------------
        | Desvincular interacciones
        |--------------------------------------------------------------------------
        */

        Reaction::where('member_id', $member->id)
            ->update(['member_id' => null]);

        Comment::where('member_id', $member->id)
            ->update(['member_id' => null]);

        /*
        |--------------------------------------------------------------------------
        | Desactivar miembro
        |--------------------------------------------------------------------------
        */

        $member->update([
            'status'      => 'inactive',
            'facebook_id' => null,
        ]);

        return redirect()
            ->route('admin.members.index')
            ->with(
                'success',
                'Miembro desactivado.'
            );
    }
}