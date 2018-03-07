<?php
/**
 * WP System - IInitializerFactory - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container; 

namespace App\Theme\Interfaces;

/******************************************/
/********** IINITIALIZER FACTORY **********/
/******************************************/

interface IInitializerFactory
{
    public function create(): IInitializer;
}