<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;

class ClearSessionController extends Controller
{
    public function clearSession(Request $request)
    {
        if(session('registration_data')) session()->forget('registration_data');
        if(session('reservation')) session()->forget('reservation');

        $route = $request->input('route');
        if(! Route::has($route)) {
            abort(404);
        }

        return to_route($route);
    }
}
