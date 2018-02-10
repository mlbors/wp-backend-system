<?php
/**
 * WP System - IConstraintsFactory - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/******************************************/
/********** ICONSTRAINTS FACTORY **********/
/******************************************/

interface IConstraintsFactory
{
    public function create(): IConstraints;
}