<?php

namespace App\Http\Controllers;

use App\Models\CommMedium;
use App\Models\Employee;
use App\Models\Address;
use App\Models\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

/**
 * Class that handles user registration
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class RegistrationController extends Controller {

    /**
     * Show registration form
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function register(Request $request){
        // If the user is logged in , then redirect to home page
        if ( !Auth::check() ) {

            return view('registration')->with('route','do-register')->with('user',$request);
        }

        return redirect()->route('home');
    }

    /**
     * Process registration form
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function doRegister(Request $request)
    {
        // If all the input fields are valid then proceed and register the user
        if ( $this->doValidation($request) ) {

            // Add employee data
            $insertEmployee = Employee::add($request);

            // If employee details are successfully inserted then proceed
            if ( $insertEmployee['success'] ) {

                $employeeId = $insertEmployee['employee_id'];

                if ( Address::add($request,$employeeId) ) {

                    if ( CommMedium::add($request,$employeeId) ) {

                        try {
                            // If all the details are successfully inserted then proceed to move photo to images dir.
                            if ( $request->hasFile('photo') ) {

                                $image = $request->file('photo');
                                $imageName = $employeeId.'_'.$image->getClientOriginalName();
                                $employee = Employee::find($employeeId);
                                $employee->photo = $imageName;
                                $employee->save();
                                $image->move('images/',$imageName);
                            }

                            $this->sendEmail($request->email,$employeeId);
                            return redirect()->route('login')->with('message','1');

                        } catch (\Exception $ex) {

                            // If image upload fails
                            Helper::log($ex);
                            CommMedium::deleteCommMedium($employeeId);
                            Address::deleteAddress($employeeId);
                            Employee::deleteEmployee($employeeId);
                            return redirect()->route('register')->with('message','0');

                        }

                    } else {

                        Address::deleteAddress($employeeId);
                        Employee::deleteEmployee($employeeId);
                        return redirect()->route('register')->with('message','0');
                    }
                } else {


                    Employee::deleteEmployee($employeeId);
                    return redirect()->route('register')->with('message','0');
                }
            } else {

                return redirect()->route('register')->with('message','0');
            }
        }


    }

    /**
     * Validates the input fields
     * @param $request
     * @param string $employeeId
     * @return bool
     */

    public function doValidation($request,$employeeId = '') {
        $statesString = implode(',',array_values(config('constants.states')));

        if ( $employeeId === '' ) {

            $checkUniqueEmail = 'email|required|max:50|unique:employees,email';
        } else {

            $checkUniqueEmail = 'email|required|max:50|unique:employees,email,'.$employeeId;
        }

        // Custom error messages
        $messages = array(
            'prefix.in' => 'Prefix must be Mr or Miss',
            'firstName.regex' => 'First Name should only contain letters',
            'gender.in' => 'Please choose a valid gender',
            'mobile.regex' => 'Mobile number must contain only digits',
            'landline.regex' => 'Landline number must contain only digits',
            'maritalStatus.in' => 'Please provide a valid Marital Status',
            'employment.in' => 'Please provide a valid Employment detail',
            'stackId.regex' => 'Stackoverflow Id must contain only digits',
            'photo.max' => 'Image size must be less than 2 MB',
            'residenceStreet.regex' => 'Residence Street must only contain these a-zA-Z0-9*() ',
            'residenceCity.regex' => 'Residence City must only contain letters and spaces',
            'residenceZip.regex' => 'Residence Zip must contain only numbers',
            'residenceFax.regex' => 'Residence Fax must contain only numbers',
            'officeStreet.regex' => 'Office Street must only contain these a-zA-Z0-9*() ',
            'officeCity.regex' => 'Office City must only contain letters and spaces',
            'officeZip.regex' => 'Office Zip must contain only numbers',
            'officeFax.regex' => 'Office Fax must contain only numbers',
        );

        // Apply validation rules
        $this->validate($request, [
            'prefix' => 'required|in:mr,miss',
            'firstName' => 'required|min:1|max:11|regex:/^[a-zA-Z ]+$/',
            'middleName' => 'max:11|alpha',
            'lastName'  => 'max:11|alpha',
            'gender' => 'required|in:male,female,others',
            'dob' => 'date',
            'mobile' => 'regex:/^[0-9]+$/|size:10',
            'landline' => 'regex:/^[0-9]+$/|size:10',
            'email' => $checkUniqueEmail,
            'password' => 'required|alpha_num|min:5|max:11',
            'maritalStatus' => 'required|in:married,unmarried',
            'employment' => 'required|in:employed,unemployed',
            'employer' => 'alpha|max:25',
            'stackId' => 'regex:/^[0-9]+$/|max:100',
            'photo' => 'mimes:jpg,png,jpeg|max:2048',
            'residenceStreet' => 'max:50|regex:/^[a-zA-Z0-9*() ]*$/',
            'residenceCity' => 'max:50|regex:/^[a-zA-Z ]*$/',
            'residenceState' => 'required|in:'.$statesString,
            'residenceZip' => 'regex:/^[0-9]+$/|size:6',
            'residenceFax' => 'regex:/^[0-9]+$/|min:10|max:15',
            'officeStreet' => 'max:50|regex:/^[a-zA-Z0-9*() ]*$/',
            'officeState' => 'required|in:'.$statesString,
            'officeCity' => 'max:50|regex:/^[a-zA-Z ]*$/',
            'officeZip' => 'regex:/^[0-9]+$/|size:6',
            'officeFax' => 'regex:/^[0-9]+$/|min:10|max:15',
            'note' => 'max:150'
        ], $messages);

        return true;
    }

    /**
     * Generate a random string for email verification
     * @param void
     * @return string
     */
    public function generateRandomString() {
        $length = 16;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Sends email to the user
     * @param $emailAddress
     * @param $employeeId
     * @param bool $isAddUser
     * @param bool $isReset
     * @return void
     */
    public function sendEmail($emailAddress, $employeeId, $isAddUser = false, $isReset = false) {

        $randomString = $this->generateRandomString();

        // Store the verification code in the database
        $employee = Employee::find($employeeId);
        $employee->verificationCode = $randomString;

        if ( $isAddUser ) {

            $employee->password = bcrypt(substr($randomString,9));
        }

        $employee->save();

        // Send mail
        Mail::send('email.activateEmail', [
            'code' => $randomString,
            'email' => Crypt::encrypt($emailAddress),
            'isAddUser' => $isAddUser,
            'emailAddress' => $emailAddress,
            'password' => substr($randomString,9),
            'isReset' => $isReset
        ],
        function ($message) use($emailAddress) {
            $message->from('vivek.m@mindfiresolutions.com','mfsi');
            $message->to($emailAddress, $name = null);
            $message->subject('Account Activation');
        });
    }
}
