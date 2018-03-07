<?php
/**
 * WP System - AbstractManagerBuilder - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IManager as IManager;
use App\Theme\Interfaces\IManagerBuilder as IManagerBuilder;
use App\Theme\Interfaces\IRequestServiceBuilder as IRequestServiceBuilder;

/**********************************************/
/********** ABSTRACT MANAGER BUILDER **********/
/**********************************************/

abstract class AbstractManagerBuilder implements IManagerBuilder
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var Array $_handlerFactores array of handler factories
     * @var IRequestServiceBuilder $_requestServiceBuilder object that builds request services
     */

    protected $_container;
    protected $_handlerFactories = [];
    protected $_requestServiceBuilder;

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
        $this->_setHandlerFactories();
        $this->_setRequestServiceBuilder();
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

    /*******************************************/
    /********** SET HANDLER FACTORIES **********/
    /*******************************************/

    abstract protected function _setHandlerFactories();

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** SET REQUEST SERVICE BUILDER **********/
    /*************************************************/

    abstract protected function _setRequestServiceBuilder();

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE MANAGER **********/
    /************************************/

    abstract protected function _createManager(): IManager;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return Mixed IManager
     */

    public function create(): IManager 
    {
        return $this->_createManager();
    }
}