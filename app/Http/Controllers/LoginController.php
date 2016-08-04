<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class to handle user login
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class LoginController extends Controller implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * Show login form
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        //If the user is logged in ,then redirect to home page,else show login page
        if ( Auth::check() ) {

            return redirect()->route('home');
        } else {

            return view('login');
        }
    }

    /**
     * Process Login form and authenticate the user
     *
     * @param  Object
     * @return \Illuminate\Http\RedirectResponse
     */

    public function doLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|alpha_num|min:5|max:11',
        ]);

        if ( Auth::attempt(['email' => $request->email, 'password' => $request->password, 'isActive' => 'yes']) ) {

            // Authentication passed...
            return redirect()->route('home')->with('login_success','1');
        } else {

            return redirect()->route('login')->with('message','3');
        }
    }
}

