<?php
/**
 * WP System - AbstractPageBuilderFactory - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IPageBuilder as IPageBuilder;
use App\Theme\Interfaces\IPageBuilderFactory as IPageBuilderFactory;
use App\Theme\Interfaces\IViewControllerFactory as IViewControllerFactory;

/***************************************************/
/********** ABSTRACT PAGE BUILDER FACTORY **********/
/***************************************************/

abstract class AbstractPageBuilderFactory implements IPageBuilderFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var IViewControllerFactory $_viewControllerFactory object that creates view controllers
     */

    protected $_container;
    protected $_viewControllerFactory;

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
        $this->_setViewControllerFactory();
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

    /*************************************************/
    /********** SET VIEW CONTROLLER FACTORY **********/
    /*************************************************/

    abstract protected function _setViewControllerFactory();

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** CREATE PAGE BUILDER **********/
    /*****************************************/

    /**
     * @return IPageBuilder
     */

    abstract protected function _createPageBuilder(): IPageBuilder;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return IPageBuilder
     */

    public function create(): IPageBuilder
    {
        return $this->_createPageBuilder();
    }
}