<?php
/**
 * WP System - AbstractPageBuilder - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IPageBuilder as IPageBuilder;
use App\Theme\Interfaces\IViewController as IViewController;
use App\Theme\Interfaces\IViewControllerFactory as IViewControllerFactory;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;

/*******************************************/
/********** ABSTRACT PAGE BUILDER **********/
/*******************************************/

abstract class AbstractPageBuilder implements IPageBuilder
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IViewController $_viewController view controller object
     * @var IViewControllerFactory $_viewControllerFactory object that creates view controllers
     * @var Array $_rows rows to use
     */

    protected $_viewController;
    protected $_viewControllerFactory;
    protected $_rows = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IViewController $viewController view controller object
     */

    public function __construct(IViewControllerFactory $viewControllerFactory)
    {
        $this->_setValues($viewControllerFactory);
        $this->_instantiateViewController();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IViewController $viewController view controller object
     */

    protected function _setValues(IViewControllerFactory $viewControllerFactory)
    {
        $this->_setViewControllerFactory($viewControllerFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** SET VIEW CONTROLLER FACTORY **********/
    /*************************************************/

    /**
     * @param IViewControllerFactory $viewControllerFactory object that creates view controllers
     */

    protected function _setViewControllerFactory(IViewControllerFactory $viewControllerFactory)
    {   
        $this->_viewControllerFactory = $viewControllerFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET VIEW CONTROLLER **********/
    /*****************************************/

    /**
     * @param IViewController $viewController view controller object
     */

    protected function _setViewController(IViewController $viewController)
    {   
        $this->_viewController = $viewController;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET ROWS **********/
    /******************************/

    /**
     * @param Array $rows rows to use
     */

    public function setRows(array $rows)
    {   
        $this->_rows = $rows;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** GET VIEW CONTROLLER FACTORY **********/
    /*************************************************/

    /**
     * @return IViewControllerFactory
     */

    public function getViewControllerFactory(): IViewControllerFactory
    {   
        return $this->_viewControllerFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET VIEW CONTROLLER **********/
    /*****************************************/

    /**
     * @return IViewController
     */

    public function getViewController(): IViewController
    {   
        return $this->_viewController;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET ROWS **********/
    /******************************/

    /**
     * @return array
     */

    public function getRows(): array
    {   
        return $this->_rows;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** INSTANTIATE VIEW CONTROLLER **********/
    /*************************************************/

    protected function _instantiateViewController()
    {
        $this->_setViewController($this->_viewControllerFactory->create());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************/
    /********** BUILD **********/
    /***************************/

    abstract public function build();
}