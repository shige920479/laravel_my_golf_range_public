<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('owner.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required',]
        ]);
        if(Auth::guard('owners')->attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::OWNER_HOME);
        } else {
            return back()->withErrors(['email' => 'メールアドレスかパスワードが違っています']);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('owners')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('owner.login');
    }
}
