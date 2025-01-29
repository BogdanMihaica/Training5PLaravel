<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = config('user.user');

        if ($user['username'] != $request->input('username') || !Hash::check($request->input('password'), $user['password'])) {
            return redirect()->back()->withErrors(['match-error' => 'Credentials don\'t match!']);
        }

        session(['user' => $user['username']]);

        redirect('/');
    }
}
