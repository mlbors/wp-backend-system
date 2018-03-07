<?php
/**
 * WP System - ISideFacade - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/**********************************/
/********** ISIDE FACADE **********/
/**********************************/

interface ISideFacade
{
    public function getSettings(): array;
    public function generateSide(): ISide;
}