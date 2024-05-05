<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_type' => 'required|in:Individual,Business',
        ]);

        $user = User::create([
            'name' => $request->name,
            'account_type' => $request->account_type,
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }
}
