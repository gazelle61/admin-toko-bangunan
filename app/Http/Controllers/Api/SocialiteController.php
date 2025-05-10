<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $socialUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $socialUser->email],
            [
                'name' => $socialUser->name,
                'google_id' => $socialUser->id,
                'google_token' => $socialUser->token,
                'google_refresh_token' => $socialUser->refreshToken,
                'password' => Hash::make('KeyauthG1'),
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }

}
