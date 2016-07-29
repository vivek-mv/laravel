<?php

namespace App\Http\Middleware;

use App\Models\Helper;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Requested resource
        $resource = explode('/',$request->getPathInfo())[1];
        $action = 'view';

        // If the user is not logged in then redirect to login page
        if ( !Auth::check() ) {

            // If ( Helper::checkPermission($resource, $action) )
            return redirect()->route('login');
        }

        // Check for user authorisation
        if ( !Helper::checkPermissions($resource, $action) ) {
            return redirect()->route('home');
        }

        // If user is authenticated and authorised , then proceed further
        return $next($request);
    }
}
