<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Services\FacebookService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class FacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')
            ->scopes(['pages_show_list'])
            ->redirect();
    }

    public function callback(FacebookService $fb)
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            Log::error('Facebook OAuth callback error', ['error' => $e->getMessage()]);
            return redirect('/login')->with('error', 'Error al conectar con Facebook. Intenta de nuevo.');
        }

        $facebookId    = $socialUser->getId();
        $facebookName  = $socialUser->getName();
        $facebookEmail = $socialUser->getEmail();
        $shortToken    = $socialUser->token;
        $avatar        = $socialUser->getAvatar();

        $longTokenData = $fb->exchangeForLongLivedToken($shortToken);
        $longToken     = $longTokenData['access_token'] ?? $shortToken;
        $expiresIn     = $longTokenData['expires_in'] ?? null;

        $user = User::where('facebook_id', $facebookId)->first();

        if (!$user) {
            $possibleMember = $this->findPossibleMemberMatch($facebookName, $facebookId);

            $user = User::create([
                'name'                => $facebookName,
                'email'               => $facebookEmail,
                'facebook_id'         => $facebookId,
                'facebook_name'       => $facebookName,
                'facebook_avatar'     => $avatar,
                'facebook_token'      => $shortToken,
                'facebook_token_long' => $longToken,
                'token_expires_at'    => $expiresIn ? now()->addSeconds($expiresIn) : null,
                'role'                => 'member',
                'member_id'           => $possibleMember?->id,
                'match_status'        => $possibleMember ? 'pending_approval' : 'unmatched',
            ]);

            if ($possibleMember) {
                Log::info("Posible match encontrado: Member #{$possibleMember->id} ↔ User #{$user->id}");
            }
        } else {
            $user->update([
                'facebook_name'       => $facebookName,
                'facebook_avatar'     => $avatar,
                'facebook_token'      => $shortToken,
                'facebook_token_long' => $longToken,
                'token_expires_at'    => $expiresIn ? now()->addSeconds($expiresIn) : null,
            ]);
        }

        Auth::login($user, true);

        if ($user->match_status === 'approved') {
            return redirect()->route('dashboard')->with('success', '¡Bienvenido, ' . $user->name . '!');
        }

        if ($user->match_status === 'pending_approval') {
            return redirect()->route('waiting')->with('info',
                'Tu cuenta está siendo verificada por el administrador.'
            );
        }

        return redirect()->route('home')->with('info',
            'Sesión iniciada. Contacta al administrador para vincular tu cuenta.'
        );
    }

    private function findPossibleMemberMatch(string $facebookName, string $facebookId): ?Member
    {
        $exact = Member::where('facebook_id', $facebookId)->first();
        if ($exact) return $exact;

        $byName = Member::where('status', 'pending')
            ->whereRaw('LOWER(name) = ?', [strtolower($facebookName)])
            ->first();
        if ($byName) return $byName;

        $nameParts = explode(' ', strtolower($facebookName));
        if (count($nameParts) >= 2) {
            $members = Member::where('status', 'pending')->get();
            foreach ($members as $member) {
                $memberParts = explode(' ', strtolower($member->name));
                $matches = count(array_intersect($nameParts, $memberParts));
                if ($matches >= 2) return $member;
            }
        }

        return null;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Sesión cerrada.');
    }
}