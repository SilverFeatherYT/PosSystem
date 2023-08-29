<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class SocialAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Check if the user exists based on the google_id
            $existingUser = User::where('google_id', $user->id)->first();

            if ($existingUser) {
                Auth::login($existingUser);

                if (Auth::user()->D_role == '2') {
                    return redirect('/MainPage');
                } elseif (Auth::user()->D_role == '1') {
                    return redirect('/Pos');
                } elseif (Auth::user()->D_role == '0') {
                    return redirect('/Redeem');
                }
            } else {
                // User with the given google_id doesn't exist, check by email
                $userByEmail = User::where('email', $user->email)->first();

                if ($userByEmail) {
                    // Update the google_id for the existing user with the same email
                    $userByEmail->update([
                        'google_id' => $user->id
                    ]);

                    Auth::login($userByEmail);

                    if (Auth::user()->D_role == '2') {
                        return redirect('/MainPage');
                    } elseif (Auth::user()->D_role == '1') {
                        return redirect('/Pos');
                    } elseif (Auth::user()->D_role == '0') {
                        return redirect('/Redeem');
                    }
                } else {

                    $lastUserId = User::orderBy('user_id', 'desc')->first(); // Get the latest user
                    $lastUserId = $lastUserId ? intval($lastUserId->user_id) : 0;
                    $newUserId = str_pad($lastUserId + 1, 3, '0', STR_PAD_LEFT);

                    // User with the given google_id and email doesn't exist, create a new user
                    $newUser = User::create([
                        'user_id' => $newUserId,
                        'google_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => Hash::make('abc')
                    ]);

                    Auth::login($newUser);

                    return redirect('/Redeem');
                }
            }
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

  
}
