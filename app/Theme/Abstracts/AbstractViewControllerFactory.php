<?php
/**
 * WP System - AbstractViewControllerFactory - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewControllerFactory as IViewControllerFactory;
use App\Theme\Interfaces\IViewController as IViewController;

/******************************************************/
/********** ABSTRACT VIEW CONTROLLER FACTORY **********/
/******************************************************/

abstract class AbstractViewControllerFactory implements IViewControllerFactory
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

    /********************************************/
    /********** CREATE VIEW CONTROLLER **********/
    /********************************************/

    abstract protected function _createViewController(): IViewController;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return IViewController
     */

    public function create(): IViewController
    {
        return $this->_createViewController();
    }
}