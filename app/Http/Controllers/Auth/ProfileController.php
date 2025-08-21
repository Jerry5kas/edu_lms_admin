<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function edit()
    {
        return view('auth.profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Check if file was uploaded
        if (!$request->hasFile('profile')) {
            return redirect()->route('auth.profile.edit')->with('error', 'Please select an image file!');
        }

        // Validate the file
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $file = $request->file('profile');
            
            // Generate unique filename
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Store the file
            $file->storeAs('public/profile_images', $filename);
            
            // Update user profile
            $user->profile = $filename;
            $user->save();

            return redirect()->route('auth.profile.edit')->with('success', 'Profile image updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->route('auth.profile.edit')->with('error', 'Error uploading image. Please try again.');
        }
    }
}
