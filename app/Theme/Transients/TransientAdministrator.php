<?php
/**
 * WP Backend System - Transient Administrator - Interface
 *
 * @since       15.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Transients;

/*********************************************/
/********** TRANSIENT ADMINISTRATOR **********/
/*********************************************/

interface TransientAdministrator
{
    public function generateBackendView();
    public static function clearTransients(): bool;
}