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
    public static function add($request) {

        try{
            $employee = new Employee;

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
                $employee->photo = $request->photo->getClientOriginalName();
            } else {
                $employee->photo = '';
            }
            $employee->note = $request->note;
            $employee->save();
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
