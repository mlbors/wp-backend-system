<?php
/**
 * WP Backend System - Main
 *
 * @since       31.07.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme;

use \App\Theme\Initializers\Initializer as Initializer;
use \App\Theme\Initializers\MainInitializer as MainInitializer;

/**************************/
/********** MAIN **********/
/**************************/

final class Main
{

    /**************************/
    /********** INIT **********/
    /**************************/

    /*
     * @return Mixed Initializer || false
     */

    public static function init()
    {
        try {
            $initializer = new MainInitializer();
            $initializer->init();
            return $initializer;
        } catch (\Exception $e) {
            return false;
        }
    }

}