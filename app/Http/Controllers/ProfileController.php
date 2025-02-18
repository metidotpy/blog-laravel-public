<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Storage;
use Str;

class ProfileController extends Controller
{

    // public function compress_image($image){
    //     $ext = $image->getClientOriginalExtension();

    //     $imageInstance = Image::make($image);

    //     $imageInstance->resize(100, 100, function($constraint){
    //         $constraint->aspectRation();

    //     });
    // }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if($request->hasFile("avatar_path")){
            $avatar = $request->file("avatar_path");
            $username = auth()->user()->username;
            $folderPath = 'avatars/' . $username;

            if($user->avatar_path && $user->avatar_path !== "default-avatar/default.png"){
                $oldAvatarPath = $user->avatar_path;
                if(Storage::disk('public')->exists($oldAvatarPath)){
                    Storage::disk('public')->delete($oldAvatarPath);
                }
            }

            if(!Storage::disk("public")->exists($username)){
                Storage::disk("public")->makeDirectory($username);
            }
            $avatarName = time() . "." . $request->file('avatar_path')->getClientOriginalExtension();
            $file_path = $username . "/" . $avatarName;
            $avatar->storeAs("/", $file_path, "public");
            // $avatarPath = Storage::disk("public")->putFileAs($folderPath, $request->file("avatar_path"), $avatarName);
            // Storage::disk("public")->delete();
            $request->user()->avatar_path = 'avatars/' . $username . '/' . $avatarName;
        }
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
