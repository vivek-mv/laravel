<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Permission;
use App\Models\Resource;
use App\Models\Role;
use App\Models\RoleResourcePermission;
use Illuminate\Http\Request;

use App\Http\Requests;

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
     * @return json
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
     * @param Request Object
     * @return view
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

            return $request->action;
        }
    }
}

