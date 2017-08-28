<?php
/**
 * WP Backend System - Handler Factory - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Taxonomies;

/*************************************/
/********** HANDLER FACTORY **********/
/*************************************/

interface HandlerFactory
{
    public function create(): Handler;
}