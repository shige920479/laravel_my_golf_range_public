<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');

        $requestUser = $this->getRequestUser($request);
        if(! $request->expectsJson()) {
            return match ($requestUser) {
                'users' => route('user.loginForm'),
                'owners' => route('owner.login'),
                'admins' => route('admin.login'),
                default => route('home')
            };
        }
        return null;
    }

    private function getRequestUser(Request $request)
    {
        if($request->routeIs('owner.*')) {
            return 'owners';
        } elseif ($request->routeIs('admin.*')) {
            return 'admins';
        } else {
            return 'users';
        }
    }

}
