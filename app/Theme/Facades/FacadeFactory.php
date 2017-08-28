<?php
/**
 * WP Backend System - Facade Factory - Interface
 *
 * @since       08.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Facades;

use App\Theme\Sides\Side as Side;

/************************************/
/********** FACADE FACTORY **********/
/************************************/

interface FacadeFactory
{
    public function create(Side $side): Facade;
}