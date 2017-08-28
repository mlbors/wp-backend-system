<?php
/**
 * WP Backend System - Handler Factory - Interface
 *
 * @since       11.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Users;

/*************************************/
/********** HANDLER FACTORY **********/
/*************************************/

interface HandlerFactory
{
    public function create(): Handler;
}