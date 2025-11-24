<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TempUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Jobs\GuideMail;

class TempRegisterController extends Controller
{
    public function create()
    {
        return view('user.auth.temp-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:50', 'confirmed', 'unique:users,email']
        ]);
        $urlToken = hash('sha256',uniqid(rand(),1));

        TempUser::create([
            'email' => $request->email,
            'secret_key' => $urlToken
        ]);
        
        return to_route('user.temporary.guide', ['token' => $urlToken]);
    }

    public function showGuide(Request $request)
    {
        // メール送信（今回は使わない）
        // $url = route('user.registration.create', ['token' => $request->token]);
        // GuideMail::dispatch($url);

        return view('user.auth.guide', ['token' => $request->token]);
        
    }

}
