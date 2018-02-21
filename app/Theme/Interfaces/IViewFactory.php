<?php
/**
 * WP System - IViewFactory - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/***********************************/
/********** IVIEW FACTORY **********/
/***********************************/

interface IViewFactory
{
    public function create(): IView;
}