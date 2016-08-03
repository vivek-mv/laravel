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
            
            return redirect()->route('login');
        }

        // If the request is for deleting account
        if ( $resource == 'delete' ) {
            if ( (Auth::user()->id == $request->id) ||  (Auth::user()->roleId ==  2) ) {
                $resource = 'details';
                $action = 'delete';
            } else {
                return redirect()->route('home')->with('unauthorised',1);
            }

        }

        // If the request is for updating account
        if ( $resource == 'update' ) {
            if ( (Auth::user()->id == $request->id) ||  (Auth::user()->roleId ==  2) ) {
                $resource = 'update';
                $action = 'view';
            } else {
                return redirect()->route('home')->with('unauthorised','1');
            }

        }

        if ( $resource == 'do-update' ) {
            if ( (Auth::user()->id == $request->id) ||  (Auth::user()->roleId ==  2) ) {
                $resource = 'update';
                $action = 'edit';
            } else {
                return redirect()->route('home')->with('unauthorised','1');
            }
        }

        // Check for user authorisation
        if ( !Helper::checkPermissions($resource, $action) ) {
            return redirect()->route('home')->with('unauthorised',1);
        }

        // Check whether user has edit permissions on dashboard page
        if ( $resource == 'dashboard' && isset(explode('/',$request->getPathInfo())[2]) ) {
            if ( explode('/',$request->getPathInfo())[2] == 'getPermissions' ) {
                if ( !Helper::checkPermissions($resource,'edit') ) {
                    return response()->json(['error_code' => 403]);
                }
           }
        }

        // Check whether user has add new user permissions on dashboard page
        if ( $resource == 'dashboard' && isset(explode('/',$request->getPathInfo())[2]) ) {
            if ( explode('/',$request->getPathInfo())[2] == 'addUser' ) {
                if ( !Helper::checkPermissions($resource,'add') ) {
                    return redirect()->route('dashboard')->with('unauthorised',1);
                }
            }
        }

        // If user is authenticated and authorised , then proceed further
        return $next($request);
    }
}
