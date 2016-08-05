<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use URL;

/**
 * Handles the user details display page
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     * And Process datatables ajax request.
     *
     * @return \Illuminate\View\View
     */
    
    public function getIndex( Request $req )
    {
        if( $req->ajax() )
        {
            // Query for displaying employee details
            $query =  Employee::join('commMedium', 'employees.id', '=', 'commMedium.employee_id')
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
                    'employees.*', 'commMedium.msg', 'commMedium.mail as commEmail' , 'commMedium.call', 'commMedium.any',
                    'residenceAddress.street AS residenceStreet','residenceAddress.city AS residenceCity'
                    ,'residenceAddress.state AS residenceState','residenceAddress.zip AS residenceZip'
                    ,'residenceAddress.fax AS residenceFax','officeAddress.street AS officeStreet'
                    ,'officeAddress.city AS officeCity','officeAddress.state AS officeState','officeAddress.zip AS officeZip'
                    ,'officeAddress.fax AS officeFax')
                ->where('isActive','yes')
                ;

            // Return Employee details json
            return Datatables::of( $query )
                ->add_column( 'Action',function ($query){
                    $view = '';
                    $edit = '';
                    $delete = '';
                    $result = '';

                    // Check for view permissions
                    if ( Helper::checkPermissions('details','view') ) {

                        // Show edit only to admin or loged in user
                        if ( ($query->id == Auth::user()->id) || (Auth::user()->roleId == 2 ) ) {

                            $view = '<li id="viewUserDetails" style="cursor: pointer"><i class="icon-pencil"></i>View Details</a></li>'.
                                '<input type="hidden" id="' . $query->id . '_mStatus" name="maritalStatus" value="' . $query->maritalStatus . '">' .
                                '<input type="hidden" id="' . $query->id. '_employment" name="employment" value="' . $query->employment . '">' .
                                '<input type="hidden" id="' . $query->id . '_residenceAddress" name="residenceAddress" value="
                                    ' . $query->residenceStreet . '<br> '.$query->residenceCity.'<br> '.$query->residenceState.'<br> '.$query->residenceZip.'">' .
                                '<input type="hidden" id="' . $query->id . '_officeAddress" name="officeAddress" value="
                                    ' . $query->officeStreet . '<br> '.$query->officeCity.'<br> '.$query->officeState.'<br> '.$query->officeZip.'">' .
                                '<input type="hidden" id="' . $query->id . '_photo" name="photo" value="' . asset('/images/'.$query->photo) . '">'.
                                '<input type="hidden" id="' . $query->id . '_name" name="name" value="' .$query->firstName.' '.$query->middleName.' '.$query->lastName. '">' .
                                '<input type="hidden" class="getEmployeeId" name="id" value="' . $query->id . '">';
                        }
                    }

                    // Check for edit permissions
                    if ( Helper::checkPermissions('details','edit') ) {

                        // Show edit only to admin or loged in user
                        if ( ($query->id == Auth::user()->id) || (Auth::user()->roleId == 2 ) ) {

                            $edit = '<li><a href="'.URL::to('update/' .$query->id).'"><i class="icon-pencil"></i> Edit</a></li>';
                        }
                    }

                    // Check for delete permissions
                    if ( Helper::checkPermissions('details','delete') ) {

                        // Show delete only to admin or loged in user
                        if ( ($query->id == Auth::user()->id) || (Auth::user()->roleId == 2 ) ) {
                            $delete = '<li><a href="'.URL::to('delete/' .$query->id).'"><i class="icon-trash"></i>Delete</a></li>';
                        }
                    }

                    if ( $edit != '' || $delete != '' ) {

                        $result = '<div class="btn-group">
                                       <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                       <ul class="dropdown-menu dropdown-menu-right">
                                           '.$view.'
                                           '.$edit.'
                                           '.$delete.'
                                       </ul>
                                   </div>';
                    }
                    return $result;
                })
                ->add_column( 'Phone','{{ $mobile}}<br>{{$landline}}')
                ->add_column(
                    'residenceAddress','{{ $residenceStreet." ".$residenceCity}}
                    <br>{{$residenceState." ".$residenceZip}}')
                ->add_column(
                    'officeAddress','{{ $officeStreet." ".$officeCity}}
                    <br>{{$officeState." ".$officeZip}}')
                ->edit_column('firstName',function ($query){
                    return
                        '<div class="showStackInfo" data-toggle="modal" data-target="#myModal" style="cursor: pointer">'
                            .$query->firstName.' '.$query->middleName.' '.$query->lastName.'
                            <input type="hidden" value='.$query->stackId.'>
                        </div>';
                })
                ->editColumn('photo',function ($query){

                    if ( ($query->photo != '') ) {

                        return '<img src="'. asset('/images/'.$query->photo) .'" atl="profile_pic" height="50px" width="50px">';
                    }

                    return $query->photo;
                })
                ->editColumn('dob',function ($query){
                        if ( $query->dob == '0000-00-00' ) {

                            $query->dob = '';
                        }

                        return $query->dob;
                })
                ->removeColumn('password')
                ->make(true);
        }

        // If the request is not ajax, then return the view
        return view('datatables.index');
    }
}
