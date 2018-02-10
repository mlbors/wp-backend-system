<?php
/**
 * WP System - ITransientServiceBuilder - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/************************************************/
/********** ITRANSIENT SERVICE BUILDER **********/
/************************************************/

interface ITransientServiceBuilder
{
    public function create();
}