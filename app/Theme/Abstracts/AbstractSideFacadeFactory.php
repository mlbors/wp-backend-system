<?php
/**
 * WP System - AbstractSideFacadeFactory - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISideFacadeFactory as ISideFacadeFactory;
use App\Theme\Interfaces\ISideFacade as ISideFacade;

/**************************************************/
/********** ABSTRACT SIDE FACADE FACTORY **********/
/**************************************************/

abstract class AbstractSideFacadeFactory implements ISideFacadeFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var ISideBuilder $_sideBuilder object that builds sides
     */

    protected $_container;
    protected $_sideBuilder;

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
        $this->_setSideBuilder();
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

    /**************************************/
    /********** SET SIDE BUILDER **********/
    /**************************************/

    abstract protected function _setSideBuilder();

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** CREATE FACADE **********/
    /***********************************/

    abstract protected function _createFacade(): ISideFacade;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return ISideFacade
     */

    public function create(): ISideFacade
    {
        return $this->_createFacade();
    }
}