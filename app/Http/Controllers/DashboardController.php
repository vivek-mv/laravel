<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Resource;
use App\Models\Role;
use App\Models\RoleResourcePermission;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;

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
     * @return view
     */
    public function getPermissions() {
        $json = [];
        $json['role'][] = Role::get();
        $json['resource'][] = Resource::get();
        $json['permission'][] = Permission::get();
        $json['rrp'][] = RoleResourcePermission::get();
        return $json;
    }
}

