<?php
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MatchApprovalController;
use Illuminate\Support\Facades\Route;

// ── Públicas ─────────────────────────────────────────────────
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/waiting', fn() => view('auth.waiting'))->name('waiting');

Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

// ── Facebook OAuth ────────────────────────────────────────────
Route::prefix('auth/facebook')->name('auth.facebook.')->group(function () {
    Route::get('/redirect', [FacebookController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [FacebookController::class, 'callback'])->name('callback');
    Route::post('/logout', [FacebookController::class, 'logout'])->name('logout');
});

// ── Autenticadas ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [EngagementController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts/{post}', [EngagementController::class, 'postDetail'])->name('posts.detail');
});

// ── API interna ───────────────────────────────────────────────
Route::prefix('api')->middleware('auth')->name('api.')->group(function () {
    Route::get('/summary', [EngagementController::class, 'apiSummary'])->name('summary');
    Route::get('/members/ranking', [EngagementController::class, 'apiMemberRanking'])->name('members.ranking');
    Route::get('/structures/ranking', [EngagementController::class, 'apiStructureRanking'])->name('structures.ranking');
});

// ── Admin ─────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('members', MemberController::class);
    Route::post('members/{member}/link-facebook', [MemberController::class, 'linkFacebook'])
        ->name('members.link-facebook');

    Route::get('matches', [MatchApprovalController::class, 'index'])->name('matches.index');
    Route::post('matches/{user}/approve', [MatchApprovalController::class, 'approve'])->name('matches.approve');
    Route::post('matches/{user}/reject', [MatchApprovalController::class, 'reject'])->name('matches.reject');
    Route::post('matches/assign', [MatchApprovalController::class, 'assignManually'])->name('matches.assign');

    Route::post('sync/posts', function() {
    dispatch(new \App\Jobs\SyncPostsJob());
    return redirect()->route('dashboard')->with('success', 'Sincronización de posts iniciado.');
})->name('sync.posts');

Route::post('sync/reactions', function() {
    dispatch(new \App\Jobs\SyncReactionsJob());
    return redirect()->route('dashboard')->with('success', 'Sincronización de reacciones iniciado.');
})->name('sync.reactions');

Route::post('sync/comments', function() {
    dispatch(new \App\Jobs\SyncCommentsJob());
    return redirect()->route('dashboard')->with('success', 'Sincronización de comentarios iniciado.');
})->name('sync.comments');

Route::post('sync/match', function() {
    dispatch(new \App\Jobs\MatchEngagementJob());
    return redirect()->route('dashboard')->with('success', 'Matching iniciado.');
})->name('sync.match');
});