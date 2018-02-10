<?php
/**
 * WP System - IRequestService - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/**************************************/
/********** IREQUEST SERVICE **********/
/**************************************/

interface IRequestService
{
    public static function buildRequest(array $args = [], array $constraints = []);
    public static function executeRequest();
}