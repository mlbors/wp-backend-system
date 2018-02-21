<?php
/**
 * WP System - ArraysHelper - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Helpers;

use Roots\Sage\Container;

/***********************************/
/********** ARRAYS HELPER **********/
/***********************************/

final class ArraysHelper
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** CHECK ARRAY **********/
    /*********************************/

    /**
     * @param Object $array array to check
     * @return Boolean
     */

    public static function checkArray($array): bool
    {
        if (empty($array)|| !is_array($array) || count(array_filter($array)) === 0 || !$array) {
            return false;
        }
        return true;
    }
}