<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CommMedium;
use App\Models\Employee;
use App\Models\Helper;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Helper controller to carry out tasks such as deleting account etc.
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class HelperController extends Controller
{
    /**
     *  Delete the user account
     * @param String $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete($id) {
        $userId = $id;
        try {
            Address::deleteAddress($userId);
            CommMedium::deleteCommMedium($userId);
            Employee::deleteEmployee($userId);

            return redirect()->route('home');
        } catch (\Exception $ex) {
            Helper::log($ex);
           return redirect()->route('home')->with('deletefailed',1);
        }
    }

    /**
     * Show the update view
     * @param String $id
     * @return html view
     */

    public function update($id) {
        $userId = $id;

        // Query for displaying employee details
        $user =  Employee::join('commMedium', 'employees.id', '=', 'commMedium.employee_id')
            ->join('address as residenceAddress', function($join)
            {
                $join->on('employees.id', '=', 'residenceAddress.employee_id')
                    ->where('residenceAddress.type','=',0);
            })
            ->join('address as officeAddress', function($join)
            {
                $join->on('employees.id', '=', 'officeAddress.employee_id')
                    ->where('officeAddress.type','=',1);
            })
            ->select(
                'employees.*', 'commMedium.msg', 'commMedium.mail AS commEmail' , 'commMedium.call', 'commMedium.any',
                'residenceAddress.street AS residenceStreet','residenceAddress.city AS residenceCity'
                ,'residenceAddress.state AS residenceState','residenceAddress.zip AS residenceZip'
                ,'residenceAddress.fax AS residenceFax','officeAddress.street AS officeStreet'
                ,'officeAddress.city AS officeCity','officeAddress.state AS officeState','officeAddress.zip AS officeZip'
                ,'officeAddress.fax AS officeFax')
            ->where('employees.id',$userId)
            ->first();

        if ( $user == null ) {

            return redirect('/');
        }

        if ( $user->gender == 'female' ) {

            $user->isFemale = true;
        } else {

            $user->isFemale = '';
        }

        if ( $user->gender == 'others' ) {

            $user->isOthers = true;
        } else {

            $user->isOthers = '';
        }

        if ( $user->dob == '0000-00-00' ) {

            $user->dob = '';
        }

        if ( $user->maritalStatus == 'unmarried' ) {

            $user->isUnmarried = true;
        } else {

            $user->isUnmarried = '';
        }

        if ( $user->employment == 'unemployed' ) {

            $user->isUnemployed = true;
        } else {

            $user->isUnemployed = '';
        }

        if ( $user->msg == '1' ) {

            $user->msg = true;
        } else {

            $user->msg = '';
        }

        if ( $user->commEmail == '1' ) {

            $user->commEmail = true;
        } else {

            $user->commEmail = '';
        }

        if ( $user->call == '1' ) {

            $user->call = true;
        } else {

            $user->call = '';
        }

        if ( $user->any == '1' ) {

            $user->any = true;
        } else {

            $user->any = '';
        }

        return view('registration')->with('user',$user)->with('route','do-update');
    }

    /**
     * Update the user details
     * @param String
     * @return html view
     */
    
    public function doUpdate(Request $request) {

        $registrationController = new RegistrationController();

        // Validate the update details
        $registrationController->doValidation($request, $request->id );

        if ( Employee::add($request, true, $request->id) && Address::add($request, $request->id, true)
            && CommMedium::add($request, $request->id, true) ) {

            try {
                // If all the details are successfully updated then proceed to move photo to images dir.
                if ( $request->hasFile('photo') ) {

                    $image = $request->file('photo');
                    $imageName = $request->id.'_'.$image->getClientOriginalName();
                    $image->move('images/',$imageName);
                }

                return redirect()->route('home')->with('updateSuccess','1');
            } catch (\Exception $ex) {
                return redirect()->route('home')->with('updateFailed','1');
            }

        } else {
            
            return redirect()->route('home')->with('updateFailed','1');
        }
    }

    /**
     * Show reset password page
     *
     * @param  Object
     * @return view
     */
    
    public function showReset()
    {
        return view('resetPassword');
    }

    /**
     * Check for valid name and email and process the reset
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function doReset(Request $request)
    {
        // Apply validation rules
        $this->validate($request, [
            'firstName' => 'required|min:1|max:11|alpha',
            'email' => 'email|required|max:50'
        ]);

        $user = Employee::where('firstName',$request->firstName)
            ->where('email',$request->email)
            ->where('isActive','yes')
            ->get();

        $isUserPresent = $user->count();

        if ( $isUserPresent == '1' ) {

            try {
                $employeeId = $user->first()->id;

                // Send email to the user
                $rc = new RegistrationController();
                $rc->sendEmail($request->email,$employeeId,false,true);
                return redirect()->route('resetPassword')->with('resetSuccess','1');
            }
            catch (\Exception $ex) {
                Helper::log($ex);
                return redirect()->route('resetPassword')->with('restFailed','1');
            }
        } else {

            return redirect()->route('resetPassword')->with('resetDetails','0');
        }
    }
}

