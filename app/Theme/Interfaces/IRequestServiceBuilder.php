<?php
/**
 * WP System - IRequestServiceBuilder - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/**********************************************/
/********** IREQUEST SERVICE BUILDER **********/
/**********************************************/

interface IRequestServiceBuilder
{
    public function create(IManager $manager);
}