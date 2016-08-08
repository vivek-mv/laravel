<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


/**
 * Helper Model
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class Helper extends Model {

    /**
     * Log the exception
     *
     * @param Exception Object
     * @return void
     */
    
    public static function log($ex) {
        Log::error($ex);
    }

    /**
     * Check User Permission on a resource,
     * If user is allowed then return true, otherwise return false
     * @param String
     * @param String
     * @return Boolean
     */

    public static function checkPermissions( $resource, $action ) {
        try {
            $roleId = Auth::user()->roleId;
            $resourceId = Resource::where('name',$resource)->first()->id;
            $permissionId = Permission::where('name', $action)->first()->id;

            $adminPermissionId = Permission::where('name', 'all')->first()->id;

            $responseUser = RoleResourcePermission::where('role_id',$roleId)
                ->where('resource_id',$resourceId)->where('permission_id',$permissionId)->first();

            $responseAdmin = RoleResourcePermission::where('role_id',$roleId)
                ->where('resource_id',$resourceId)->where('permission_id',$adminPermissionId)->first();

            if ( ($responseUser != null) || ($responseAdmin != null) ) {
                
                return true;
            }
            
            return false;
        } catch (\Exception $ex) {
            Helper::log($ex);
            return false;
        }

    }
}
