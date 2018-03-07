<?php
/**
 * WP System - RequestService - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Services;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraintsFactory as IConstraintsFactory;
use App\Theme\Interfaces\IRequestFactory as IRequestFactory;
use App\Theme\Abstracts\AbstractRequestService as AbstractRequestService;

/*************************************/
/********** REQUEST SERVICE **********/
/*************************************/

class RequestService extends AbstractRequestService
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {
    }
}