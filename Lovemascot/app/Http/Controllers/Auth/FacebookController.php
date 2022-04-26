<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class FacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        $user = Socialite::driver('facebook')->user();
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            auth()->login($existingUser);
            return redirect()->to('/home');
        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = bcrypt($user->id);
            $newUser->save();
            auth()->login($newUser);
            return redirect()->to('/home');
        }
    }
}
