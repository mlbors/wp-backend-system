<?php
/**
 * WP System - IRedirection - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container; 

namespace App\Theme\Interfaces;

/**********************************/
/********** IREDIRECTION **********/
/**********************************/

interface IRedirection 
{
    public function apply();
}