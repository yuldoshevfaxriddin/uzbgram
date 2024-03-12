<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
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

        $retsepts =$user->retsepts;
        $comments =$user->comments;
        $likes =$user->like;

        foreach($retsepts as $retsept){
            foreach($retsept->like as $like){
                $like->delete();
            }
            foreach($retsept->comments as $comment){
                $comment->delete();
            }
            \Illuminate\Support\Facades\Storage::delete($retsept->image);
            $retsept->delete();
        }
        foreach($comments as $comment){
            $comment->delete();
        }
        foreach($likes as $like){
            $like->delete();
        }
        if($user->image !='images/default_user_avatar.jpg'){
            \Illuminate\Support\Facades\Storage::delete($user->image);
        }
    
        $user->delete();
        Auth::logout();


        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
