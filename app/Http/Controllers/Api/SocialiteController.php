<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
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
        try {
            $socialUser = Socialite::driver('google')->user();

            $user = Users::updateOrCreate(
                ['email' => $socialUser->email],
                [
                    'name' => $socialUser->name,
                    'google_id' => $socialUser->id,
                    'google_token' => $socialUser->token,
                    'google_refresh_token' => $socialUser->refreshToken,
                    'password' => Hash::make('KeyauthG1'),
                ]
            );

            $token = $user->createToken('google-login')->plainTextToken;

            $frontendUrl = 'https://tbnoto19.rplrus.com/#token=' . $token;

            return redirect()->away($frontendUrl);
        } catch (\Exception $e) {
            return redirect()->away('https://tbnoto19.rplrus.com/masuk?error=' . urlencode($e->getMessage()));
        }
    }
}
