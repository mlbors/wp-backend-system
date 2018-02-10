<?php
/**
 * WP System - TransientService - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Services;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraintsFactory as IConstraintsFactory;
use App\Theme\Interfaces\IRequestFactory as IRequestFactory;
use App\Theme\Abstracts\AbstractTransientService as AbstractTransientService;

/***************************************/
/********** TRANSIENT SERVICE **********/
/***************************************/

class TransientService extends AbstractTransientService
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {
    }
}