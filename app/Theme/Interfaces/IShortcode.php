<?php
/**
 * WP System - IShortcode - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/********************************/
/********** ISHORTCODE **********/
/********************************/

interface IShortcode
{
    public function register();
}