<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CommMedium;
use App\Models\Employee;
use App\Models\Helper;
use App\Models\Permission;
use App\Models\Resource;
use App\Models\Role;
use App\Models\RoleResourcePermission;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

/**
 * Show dashboard and manage permissions
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */
class DashboardController extends Controller
{
    /**
     * Show the user dashboard
     * @param void
     * @return view
     */

    public function showDashboard() {
        return view('dashboard');
    }

    /**
     * Generate response for ajax calls to show user permissions
     * @param void
     * @return array
     */

    public function getPermissions() {
        $json = [];
        $json['role'][] = Role::get();
        $json['resource'][] = Resource::get();
        $json['permission'][] = Permission::get();
        $json['rrp'][] = RoleResourcePermission::get();
        return $json;
    }

    /**
     * Get the action and accordingly change the permissions in the database
     * @param Request $request
     * @return string
     */

    public function setPermissions(Request $request) {

        if ( $request->action == 'add' ) {

            try{
                $rrp = new RoleResourcePermission();
                $rrp->role_id = $request->roleId;
                $rrp->resource_id = $request->resourceId;
                $rrp->permission_id = $request->permissionId;
                $rrp->save();
                return '{"success":1}';
            } catch (\Exception $ex) {
                Helper::log($ex);
                return '{"success":0}';
            }
        } elseif( $request->action == 'delete' ) {

            try{
                RoleResourcePermission::where('role_id',$request->roleId)
                    ->where('resource_id',$request->resourceId)
                    ->where('permission_id',$request->permissionId)
                    ->delete();
                return '{"success":1}';
            } catch (\Exception $ex) {
                Helper::log($ex);
                return '{"success":0}';
            }
        }
    }

    /**
     * Process the input fields from the add user form and add the user in database
     * and send an activation link to the user's email
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function addUser(Request $request) {

        // Apply validation rules
        $this->validate($request, [
            'firstName' => 'required|min:1|max:11|alpha',
            'email' => 'email|required|max:50|unique:employees,email,'.Auth::user()->id,
            'password' => 'required|alpha_num|min:5|max:11'
        ]);

        try{
            // Add employee data
            $insertEmployee = Employee::add($request);

            // If employee details are successfully inserted then proceed
            if ( $insertEmployee['success'] ) {

                $employeeId = $insertEmployee['employee_id'];

                if ( Address::add($request,$employeeId) ) {

                    if ( CommMedium::add($request,$employeeId) ) {

                        try {
                            // Send email to the user
                            $rc = new RegistrationController();
                            $rc->sendEmail($request->email,$employeeId,true);
                            return redirect()->route('dashboard')->with('addUser','1');
                        }
                        catch (\Exception $ex) {
                            Helper::log($ex);
                            CommMedium::deleteCommMedium($employeeId);
                            Address::deleteAddress($employeeId);
                            Employee::deleteEmployee($employeeId);
                            return redirect()->route('dashboard')->with('addUser','0');
                        }

                    } else {

                        Address::deleteAddress($employeeId);
                        Employee::deleteEmployee($employeeId);
                        return redirect()->route('dashboard')->with('addUser','0');
                    }

                } else {

                    Employee::deleteEmployee($employeeId);
                    return redirect()->route('dashboard')->with('addUser','0');
                }

            } else {

                return redirect()->route('dashboard')->with('addUser','0');
            }
        }
        catch (\Exception $ex) {
            Helper::log($ex);
            return redirect()->route('dashboard')->with('addUser','0');
        }

    }
}

