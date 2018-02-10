<?php
/**
 * WP System - IRequest - Interface
 *
 * @since       12.01.2018
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