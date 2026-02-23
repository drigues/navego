<?php

namespace App\Http\Traits;

use App\Models\User;

trait RedirectsAfterAuth
{
    protected function redirectTo(User $user): string
    {
        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        }

        if ($user->hasRole('provider')) {
            return route('prestador.dashboard');
        }

        return route('home');
    }
}
