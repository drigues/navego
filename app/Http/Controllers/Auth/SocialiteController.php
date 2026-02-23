<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\RedirectsAfterAuth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    use RedirectsAfterAuth;

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Não foi possível autenticar com o Google. Tente novamente.']);
        }

        // Find by google_id first, then by email (link existing account)
        $user = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Sync Google data if not yet linked
            $user->update([
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
            ]);
        } else {
            // New user via Google — create and assign default role
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => null,
            ]);

            $user->assignRole('user');
        }

        Auth::login($user, remember: true);

        return redirect($this->redirectTo($user));
    }
}
