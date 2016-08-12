<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CommMedium;
use App\Models\Employee;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class to handle user login
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class LoginController extends Controller implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * Show login form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function login(Request $request)
    {
        //If the user is logged in, then redirect to home page, else show login page
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

    public function doLogin(Request $request) {

        $this->validate($request, [
            'email' => 'email|required|max:50',
            'password' => 'required|alpha_num|min:5|max:11',
        ]);

        if ( Auth::attempt(['email' => $request->email, 'password' => $request->password, 'isActive' => 'yes']) ) {

            // Authentication passed...
            return redirect()->route('home')->with('login_success','1');
        } else {

            return redirect()->route('login')->with('message','3');
        }
    }

    /**
     * Process Login with Facebook
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginWithOthers($others = 0) {

        if ( $others == 1 ) {

            $user = \Socialize::with('google')->user();
        } elseif ( $others == 2 ) {

            $user = \Socialize::with('linkedin')->user();
        } elseif ( $others == 3 ) {

            $user = \Socialize::with('twitter')->user();
        } elseif ( $others == 4 ) {

            $user = Socialite::driver('instagram')->user();
        } else {

            $user = \Socialize::with('facebook')->user();
        }

        if ( $user->getEmail() == null ) {

            $emp = Employee::where('clientId', $user->getId())
                ->get();
        } else {

            $emp = Employee::where('email', $user->getEmail())
                ->get();
        }

        $isUserPresent = $emp->count();

        if ( $isUserPresent == '1' ) {

            if ( Auth::loginUsingId($emp->first()->id) ) {

                // Authentication passed...
                return redirect()->route('home')->with('login_success','1');
            } else {

                return redirect()->route('login')->with('loginFailed','1');
            }

        } else {

            // If the social newtork client doesnt provide any email, then assign a temporary email to the user
            if ( $user->getEmail() == null ) {

                $user->email = $user->getId().'@email.com';
            }

            $request = new Request();
            $request->prefix = 'mr';
            $request->firstName = $user->getName();
            $request->gender = 'male';
            $request->dob = '';
            $request->email = $user->getEmail();
            $request->password = 'vivek';
            $request->maritalStatus = 'married';
            $request->employment = 'employed';
            $request->stackId = '';

            $employee = Employee::add($request);
            $status = Employee::find($employee['employee_id']);
            $status->isActive = 'yes';
            $status->clientId = $user->getId();
            $status->save();
            Address::add($request, $employee['employee_id']);
            CommMedium::add($request, $employee['employee_id']);

            if ( Auth::loginUsingId($employee['employee_id']) ) {

                // Authentication passed...
                return redirect('update/'.$employee['employee_id'])->with('updateDetails','1');
            } else {

                return redirect()->route('login')->with('loginFailed','1');
            }
        }
    }
}

