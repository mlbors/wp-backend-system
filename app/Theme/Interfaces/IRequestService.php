<?php
/**
 * WP System - IRequestService - Interface
 *
 * @since       2018.01.12
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