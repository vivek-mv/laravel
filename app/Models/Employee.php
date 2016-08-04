<?php

namespace App\Models;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Employee Model
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class Employee extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'employees';

    /**
     * Insert employee details
     *
     * @param request object
     * @return boolean
     */

    public static function add($request, $isUpdate = false, $userId = '') {

        try{
            // Check if the request is to create a new user or update an existing user

            if ( $isUpdate ) {

                $employee = Employee::find($userId);
            } else {

                // If the request is to create new user
                $employee = new Employee;
            }
            $employee->prefix = $request->prefix;
            $employee->firstName = $request->firstName;
            $employee->middleName = $request->middleName;
            $employee->lastName = $request->lastName;
            $employee->gender = $request->gender;
            $employee->dob = $request->dob;
            $employee->mobile = $request->mobile;
            $employee->landline = $request->landline;
            $employee->email = $request->email;
            $employee->password = bcrypt($request->password);
            $employee->maritalStatus = $request->maritalStatus;
            $employee->employment = $request->employment;
            $employee->employer = $request->employer;
            $employee->stackId = $request->stackId;
            if ( $request->photo != null ) {

                // Delete the previous image if present when the request is for update
                if ( $isUpdate ) {

                    if ( $employee->photo != '' ) {

                        unlink(getcwd().'/images/'.$employee->photo );
                    }
                }
                $employee->photo = $request->id.'_'.$request->photo->getClientOriginalName();

            } else {

                if ( !$isUpdate ) {

                    $employee->photo = '';
                }
            }
            $employee->note = $request->note;
            $employee->save();

            // If the request is for update, then only return true
            if ( $isUpdate ) {

                return true;
            }
            return ['success' => true,'employee_id' => $employee->id];
        } catch (\Exception $ex) {

            Helper::log($ex);
            return false;

        }
    }

    /**
     * Delete employee table
     *
     * @param String
     * @return void
     */

    public static function deleteEmployee($employeeId) {
        Employee::destroy($employeeId);
    }
}
