<?php
/**
 * WP System - ITransientService - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/****************************************/
/********** ITRANSIENT SERVICE **********/
/****************************************/

interface ITransientService
{
    public static function tryToRetrieveTransient(string $name, int $lifeTime = 5);
    public static function initTransient(string $name, int $lifeTime = 5, $data);
}