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
use Html;

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
        if( $req->ajax() ) {

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
                ->where('isActive','yes');

            // Return Employee details json
            return Datatables::of( $query )
                ->add_column( 'Action',function ($query){
                    $view = '';
                    $showStackInfo = '';
                    $edit = '';
                    $delete = '';
                    $result = '';

                    // Check for view permissions
                    if ( Helper::checkPermissions('details','view') ) {

                        // Show edit only to admin or loged in user
                        if ( ($query->id == Auth::user()->id) || (Auth::user()->roleId == 2 ) ) {

                            $view = view('userDetailsBtn')->with('query', $query);
                            $showStackInfo = view('stackInfoBtn')->with('query', $query);
                        }
                    }

                    // Check for edit permissions
                    if ( Helper::checkPermissions('details','edit') ) {

                        // Show edit only to admin or loged in user
                        if ( ($query->id == Auth::user()->id) || (Auth::user()->roleId == 2 ) ) {

                            $edit = view('editBtn')->with('query', $query);
                        }
                    }

                    // Check for delete permissions
                    if ( Helper::checkPermissions('details','delete') ) {

                        // Show delete only to admin or loged in user
                        if ( ($query->id == Auth::user()->id) || (Auth::user()->roleId == 2 ) ) {
                            $delete = view('deleteBtn');
                        }
                    }

                    if ( $edit != '' || $delete != '' ) {

                        $result = view('actionBtn', array(
                            'view' => $view ,
                            'showStackInfo' => $showStackInfo ,
                            'edit' => $edit ,
                            'delete' => $delete
                        ));
                    }

                    return $result;
                })
                ->add_column( 'Phone','{{ $mobile }}<br>{{ $landline }}')
                ->add_column(
                    'residenceAddress','{{ $residenceStreet." ".$residenceCity}}
                    <br>{{$residenceState." ".$residenceZip}}')
                ->add_column(
                    'officeAddress','{{ $officeStreet." ".$officeCity}}
                    <br>{{$officeState." ".$officeZip}}')
                ->edit_column('firstName',function ($query){

                    return view('nameField')->with('query', $query);
                })
                ->editColumn('photo',function ($query){

                    if ( ($query->photo != '') ) {

                        return Html::image( asset('/images/'.$query->photo), 'Image', array( 'width' => 50, 'height' => 50 ) );
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
