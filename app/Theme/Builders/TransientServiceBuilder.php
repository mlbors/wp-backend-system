<?php
/**
 * WP System - TransientServiceBuilder - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\ITransientService as ITransientService;
use App\Theme\Abstracts\AbstractTransientServiceBuilder as AbstractTransientServiceBuilder;
use App\Theme\Services\TransientService as TransientService;

/***********************************************/
/********** TRANSIENT SERVICE BUILDER **********/
/***********************************************/

class TransientServiceBuilder extends AbstractTransientServiceBuilder
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** CREATE TRANSIENT SERVICE **********/
    /**********************************************/

    protected function _createTransientService()
    {
        return TransientService::get();
    }
}