<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    public function index()
    {
        // Fetch all users with user_role != 0 (exclude users with user_role = 0)
        $users = User::where('user_role', '!=', 0)->get();
        return view('users.index', compact('users'));
    }

    /**
     * Display the form to edit a user (admin only).
     */
    public function editAdmin($id): View
    {
        // Fetch the user with the given ID
        $user = User::findOrFail($id);

        return view('users.edit-admin', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user information for a specific user (admin only).
     */
    public function updateUserInformation(ProfileUpdateRequest $request, $id): RedirectResponse
    {
        // Fetch the user with the given ID
        $user = User::findOrFail($id);

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('users.index')->with('success', 'User profile updated successfully.');
    }


    /**
     * Delete a specific user (admin only).
     */
    public function deleteUser($id): RedirectResponse
    {
        // Fetch the user with the given ID
        $user = User::findOrFail($id);

        // Perform any additional actions required before deletion (if needed)

        $user->delete();

        return Redirect::route('users.index')->with('success', 'User deleted successfully.');
    }
}
