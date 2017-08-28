<?php
/**
 * WP Backend System - Side Factory - Interface
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Sides;

/**********************************/
/********** SIDE FACTORY **********/
/**********************************/

interface SideFactory
{
    public function createSide(): Side;
}