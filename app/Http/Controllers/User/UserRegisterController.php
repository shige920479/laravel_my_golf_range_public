<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\TempUser;
use App\Models\User;
use App\Services\TokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDOException;

class UserRegisterController extends Controller
{
    public function create(Request $request)
    {
        $tempUserData = TokenService::checkToken($request->token);
        // $tempUserData = $this->checkToken($request->token);
        if(empty($tempUserData)) {
            return to_route('user.temporary.create')
            ->with('message', 'URLが無効です。再度、仮登録をお願い致します。');
        } else {
            $userEmail = $tempUserData->email;
            $urlToken = $request->token; 
            return view('user.auth.registration', compact('userEmail', 'urlToken'));
        }        
    }

    public function store(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();
        session(['registration_data' => $validatedData]);

        return to_route('user.registration.confirm', ['token' => $request->token])
        ->withInput();
    }

    public function confirm(Request $request)
    {
        $data = session('registration_data');
        $urlToken = $request->token;
        if(! $data) {
            return to_route('user.registrarion', compact('urlToken'))
            ->with('message', 'エラーが発生しました。お手数ですが再入力をお願いします');
        }
        return view('user.auth.registration-confirm', compact('data', 'urlToken'));
    }

    public function send(Request $request)
    {   
        $data = session('registration_data');
        $urlToken = $request->token;
        $data['password'] = Hash::make($data['password']);
        if(! $data) {
            return to_route('user.registration',['token' => $urlToken])
            ->with('message', 'エラーが発生しました。お手数ですが再入力をお願いします');
        }
        try {
            DB::beginTransaction();
            User::create($data);
            session()->forget('registration_data');
            TempUser::where('secret_key', $urlToken)->first()->delete();
            DB::commit();

            return redirect()->route('user.registration.complete',['token' => $urlToken]);

        } catch(PDOException $e) {
            DB::rollBack();
            abort(500);
        }
    }

    public function complete()
    {
        return view('user.auth.complete');
    }
}
