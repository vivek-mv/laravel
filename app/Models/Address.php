<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/**
 * Address Model class
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */

class Address extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    protected $table = 'address';

    /**
     * Insert address details
     *
     * @param request object
     * @return boolean
     */
    
    public static function add($request, $employee_id, $isUpdate = false) {

        try{

            // Check for request type : Create new or update exisitng
            if ( $isUpdate ) {
                
                $address = Address::where('employee_id',$employee_id)->where('type',0)->first();
            } else {
                
                // Insert Residence Address
                $address = new Address;
            }
            $address->employee_id = $employee_id;
            $address->type = 0;
            $address->street = $request->residenceStreet;
            $address->city = $request->residenceCity;
            $address->state = $request->residenceState;
            $address->zip = $request->residenceZip;
            $address->fax = $request->residenceFax;
            $address->save();

            // Check for request type : Create new or update exisitng
            if ( $isUpdate ) {
                
                $address = Address::where('employee_id', $employee_id)->where('type',1)->first();
            } else {
                
                // Insert Residence Address
                $address = new Address;
            }

            $address->employee_id = $employee_id;
            $address->type = 1;
            $address->street = $request->officeStreet;
            $address->city = $request->officeCity;
            $address->state = $request->officeState;
            $address->zip = $request->officeZip;
            $address->fax = $request->officeFax;
            $address->save();

            // Return true if insert is successful
            return true;
        } catch (\Exception $ex) {
            Helper::log($ex);
            return false;
        }
    }

    /**
     * Delete Address table
     *
     * @param request object
     * @return void
     */

    public static function deleteAddress($employeeId) {
        Address::where('employee_id',$employeeId)->delete();
    }
}
