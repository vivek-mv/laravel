<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;

/**
 * User email verification and account activation
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */
class VerifyUserController extends Controller
{
    /**
     * Verify the user's email and activate his account
     *
     * @param String
     * @param String
     * @return view
     */
    public function verifyUser($email, $activationCode) {
        try{
            $user = Employee::where('email',Crypt::decrypt($email))->where('verificationCode', $activationCode)->first();

            // If user is present then activate the account and redirect to login page
            if ( $user ) {

                $employee = Employee::find($user->id);
                $employee->isActive = 'yes';
                $employee->verificationCode = null;
                $employee->save();
                return redirect()->route('login')->with('message','2');
            } else {
                return redirect()->route('login');
            }
        } catch (\Exception $ex) {
            // If any exception occurs ,then redirect to login page
            return redirect()->route('login');
        }


    }
}

