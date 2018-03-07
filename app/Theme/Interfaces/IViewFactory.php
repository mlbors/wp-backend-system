<?php
/**
 * WP System - IViewFactory - Interface
 *
 * @since       2018.01.12
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