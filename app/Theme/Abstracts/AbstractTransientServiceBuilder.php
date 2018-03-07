<?php
/**
 * WP System - AbstractTransientServiceBuilder - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\ITransientService as ITransientService;
use App\Theme\Interfaces\ITransientServiceBuilder as ITransientServiceBuilder;

/***********************************************/
/********** TRANSIENT SERVICE BUILDER **********/
/***********************************************/

abstract class AbstractTransientServiceBuilder implements ITransientServiceBuilder
{   
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     */

    protected $_container;

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

    /**********************************************/
    /********** CREATE TRANSIENT SERVICE **********/
    /**********************************************/

    abstract protected function _createTransientService();

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return Mixed ITransientService
     */

    public function create()
    {
        $service = $this->_createTransientService();
        return $service;
    }
}