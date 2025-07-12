<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    // Display the password change form
    public function index()
    {
        return view('auth.change-password');
    }

    // Process the password change
   public function store(Request $request)
{
    
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Your current password does not match our records.']);
    }

    // Update the password using the model's update method
    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return redirect()->route('home')->with('success', 'Your password has been changed successfully.');
}
}
