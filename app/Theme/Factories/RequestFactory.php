<?php
/**
 * WP System - RequestFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Abstracts\AbstractRequestFactory as AbstractRequestFactory;
use App\Theme\Requests\Request as Request;

/*************************************/
/********** REQUEST FACTORY **********/
/*************************************/

class RequestFactory extends AbstractRequestFactory
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

    /************************************/
    /********** CREATE REQUEST **********/
    /************************************/

    /**
     * @return IRequest
     */

    protected function _createRequest(): IRequest
    {
        return $this->_container->make(Request::class);
    }
}