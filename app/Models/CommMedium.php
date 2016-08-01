<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/**
 * Communication medium Model class
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */
class CommMedium extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commMedium';

    /**
     * Insert communication medium details
     *
     * @param request object
     * @param String
     * @return boolean
     */
    public static function add($request, $employee_id,  $isUpdate = false) {

        if ( $request->commMed == null ) {
            $request->commMed = [];
        }

        try{
            // Check for request type : New user or Update current user
            if ( $isUpdate ) {
                $commMedium = CommMedium::where('employee_id', $employee_id)->first();
            } else {
                // Insert Communication Medium
                $commMedium = new CommMedium;
            }
            $commMedium->employee_id = $employee_id;
            $commMedium->msg = (in_array('msg',$request->commMed) ? 1 : 0);
            $commMedium->mail = (in_array('mail',$request->commMed) ? 1 : 0);;
            $commMedium->call = (in_array('phone',$request->commMed) ? 1 : 0);
            $commMedium->any = (in_array('any',$request->commMed) ? 1 : 0);
            $commMedium->save();

            // Return true if insert is successful
            return true;
        } catch (\Exception $ex) {

            Helper::log($ex);
            return false;
        }
    }

    /**
     * Delete communication medium
     * @param String
     * @return void
     */
    public static function deleteCommMedium($employeeId) {

        CommMedium::where('employee_id', $employeeId)->delete();
    }
}
