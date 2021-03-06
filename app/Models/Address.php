<?php

namespace App\Models;

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
class Address extends Model
{
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
    public static function add($request,$employee_id) {

        try{
            // Insert Residence Address
            $address = new Address;
            $address->employee_id = $employee_id;
            $address->type = 0;
            $address->street = $request->residenceStreet;
            $address->city = $request->residenceCity;
            $address->state = $request->residenceState;
            $address->zip = $request->residenceZip;
            $address->fax = $request->residenceFax;
            $address->save();

            //Insert Office Address
            $address = new Address;
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
