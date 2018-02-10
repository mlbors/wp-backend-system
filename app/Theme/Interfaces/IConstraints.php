<?php
/**
 * WP System - IConstraints - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/*********************************/
/********** ICONTRAINTS **********/
/*********************************/

interface IConstraints
{
    public function set(array $args = []);
    public function get(): IConstraints;
}