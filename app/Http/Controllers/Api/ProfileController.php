<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request): JsonResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email']);

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            // Delete old profile image if exists
            if ($user->profile && Storage::disk('public')->exists('profile_images/' . $user->profile)) {
                Storage::disk('public')->delete('profile_images/' . $user->profile);
            }

            $profile = $request->file('profile');
            $profileName = time() . '_' . Str::random(10) . '.' . $profile->getClientOriginalExtension();
            $profile->storeAs('profile_images', $profileName, 'public');
            $data['profile'] = $profileName;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}
