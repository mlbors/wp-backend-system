<?php
/**
 * WP System - TransientsHelper - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Helpers;

use Roots\Sage\Container;

/***************************************/
/********** TRANSIENTS HELPER **********/
/***************************************/

final class TransientsHelper
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {  
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /**************************************/
    /********** CLEAR TRANSIENTS **********/
    /**************************************/

    /**
     * @return Bool
     */

    public static function clearTransients(): bool
    {
        global $wpdb;
        $registeredTransients = get_option('transients_list');

        if (empty($registeredTransients) || !is_array($registeredTransients)) {
            return false;
        }

        $query = "DELETE FROM " . $wpdb->prefix . "options WHERE `option_name` IN ( ";

        $arraySize = count($registeredTransients);
        $arrayToUse = array();

        foreach ($registeredTransients as $t => $transient) {
            $query .= "%s, %s, ";
            array_push($arrayToUse, "_transient_" . $transient, "_transient_timeout_" . $transient);
        }   

        $query = substr($query, 0, -2);
        $query .= " )";

        $wpdb->query($wpdb->prepare($query, $arrayToUse));

        return true;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** HARD RESET **********/
    /********************************/

    /**
     * @return Bool
     */

    public static function hardReset(): bool
    {
        if (self::clearTransients()) {
            update_option('transients_list', []);
            return true;
        }
        return false;
    }
}