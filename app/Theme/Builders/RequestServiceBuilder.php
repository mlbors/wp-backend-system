<?php
/**
 * WP System - RequestServiceBuilder - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraintsFactory as IConstraintsFactory;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequestFactory as IRequestFactory;
use App\Theme\Abstracts\AbstractRequestServiceBuilder as AbstractRequestServiceBuilder;
use App\Theme\Factories\ConstraintsFactory as ConstraintsFactory;
use App\Theme\Factories\RequestFactory as RequestFactory;
use App\Theme\Services\RequestService as RequestService;

/*********************************************/
/********** REQUEST SERVICE BUILDER **********/
/*********************************************/

class RequestServiceBuilder extends AbstractRequestServiceBuilder
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

    /*****************************************/
    /********** SET REQUEST FACTORY **********/
    /*****************************************/

    protected function _setRequestFactory()
    {
        $this->_requestFactory = $this->_container->make(RequestFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** SET CONSTRAINTS FACTORY **********/
    /*********************************************/

    protected function _setConstraintsFactory()
    {
        $this->_constraintsFactory = $this->_container->make(ConstraintsFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** CREATE REQUEST SERVICE **********/
    /********************************************/

    protected function _createRequestService()
    {
        return RequestService::get();
    }
}