<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(){
        try {
            $googleuser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleuser->getemail()],
                [
                    'name' => $googleuser->getName(),
                    'google_id' => $googleuser->getId(),
                    'password' => encrypt('google')

                ]
            );
            Auth::login($user);
            return redirect('/dashboard');
        } catch (Exception $e){
            return redirect('/login')->with('error','something went wrong');
        }
    }
}
