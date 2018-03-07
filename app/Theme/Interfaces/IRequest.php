<?php
/**
 * WP System - IRequest - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/******************************/
/********** IREQUEST **********/
/******************************/

interface IRequest
{
    public function set(array $args = [], IConstraints $constraints = null);
    public function get(): IRequest;
}