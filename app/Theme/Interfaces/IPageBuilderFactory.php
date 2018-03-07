<?php
/**
 * WP System - IPageBuilderFactory - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/*******************************************/
/********** IPAGE BUILDER FACTORY **********/
/*******************************************/

interface IPageBuilderFactory
{
    public function create(): IPageBuilder;
}