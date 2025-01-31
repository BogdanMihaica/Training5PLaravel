<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\returnSelf;

class SessionController extends Controller
{
    public function create()
    {
        if (!session('user')) {
            return view('login');
        }
    }

    /**
     * Log in the user ifthe credentials get validated
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect('/products');
    }

    public function destroy()
    {
        if (session('user')) {
            session()->remove('user');
            return redirect('/login');
        } else {
            return redirect()->back();
        }
    }
}
