<?php
/**
 * WP System - IRequestFactory - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container; 

namespace App\Theme\Interfaces;

/**************************************/
/********** IREQUEST FACTORY **********/
/**************************************/

interface IRequestFactory
{
    public function create(): IRequest;
}