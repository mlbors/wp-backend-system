<?php
/**
 * WP System - PluginsHelper - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Helpers;

use Roots\Sage\Container;

/************************************/
/********** PLUGINS HELPER **********/
/************************************/

final class PluginsHelper
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
    /********** CHECK CLASS **********/
    /*********************************/

    /**
     * @param String $class class to check
     * @return Boolean
     */

    public static function checkClass(string $class): bool
    {
        if(!class_exists($class)) {
            return false;
        }
        return true;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CHECK FUNCTION **********/
    /************************************/

    /**
     * @param String $function function to check
     * @return Boolean
     */

    public static function checkFunction(string $function): bool
    {
        if(!function_exists($class)) {
            return false;
        }
        return true;
    }
}