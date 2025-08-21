<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function edit()
    {
        return view('auth.profile.edit'); // we are using Auth::user() directly in Blade
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_images', $filename);

            $user->profile = $filename;
            $user->save();
        }

        return redirect()->route('auth.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
