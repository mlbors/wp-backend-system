<?php
/**
 * WP System - AbstractInitializerFactory - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IInitializer as IInitializer;
use App\Theme\Interfaces\IInitializerFactory as IInitializerFactory;

/**************************************************/
/********** ABSTRACT INITIALIZER FACTORY **********/
/**************************************************/

abstract class AbstractInitializerFactory implements IInitializerFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var ISideFacadeFactory $_sideFacadeFactory object that creates side facades
     */

    protected $_container;
    protected $_sideFacadeFactory;

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
        $this->_setSideFacadeFactory();
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

    /*********************************************/
    /********** SET SIDE FACADE FACTORY **********/
    /*********************************************/

    abstract protected function _setSideFacadeFactory();

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CREATE INITIALIZER **********/
    /****************************************/

    abstract protected function _createInitializer(): IInitializer;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return IInitializer
     */

    public function create(): IInitializer
    {
        return $this->_createInitializer();
    }
}