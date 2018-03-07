<?php
/**
 * WP System - AbstractRequestServiceBuilder - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraintsFactory as IConstraintsFactory;
use App\Theme\Interfaces\IManager as IManager;
use App\Theme\Interfaces\IRequestFactory as IRequestFactory;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequestServiceBuilder as IRequestServiceBuilder;

/*********************************************/
/********** REQUEST SERVICE BUILDER **********/
/*********************************************/

abstract class AbstractRequestServiceBuilder implements IRequestServiceBuilder
{   
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var IRequestFactory $_requestFactory object that creates requests
     * @var IConstraintsFactory $_constraintsFactory object that creates constraints
     */

    protected $_container;
    protected $_requestFactory;
    protected $_constraintsFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        $this->_setValues();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    protected function _setValues()
    {
        $this->_setContainer();
        $this->_setRequestFactory();
        $this->_setConstraintsFactory();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** SET CONTAINER **********/
    /***********************************/

    protected function _setContainer()
    {
        $this->_container = Container::getInstance();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST FACTORY **********/
    /*****************************************/

    abstract protected function _setRequestFactory();

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** SET CONSTRAINTS FACTORY **********/
    /*********************************************/

    abstract protected function _setConstraintsFactory();

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** CREATE REQUEST SERVICE **********/
    /********************************************/

    abstract protected function _createRequestService();

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return Mixed IRequestService
     */

    public function create(IManager $manager)
    {
        $service = $this->_createRequestService();
        $service::init($manager, $this->_requestFactory, $this->_constraintsFactory);
        return $service;
    }
}