<?php
/**
 * WP System - AbstractViewController - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewController as IViewController;
use App\Theme\Interfaces\IView as IView;
use App\Theme\Interfaces\IViewFactory as IViewFactory;

/**********************************************/
/********** ABSTRACT VIEW CONTROLLER **********/
/**********************************************/

abstract class AbstractViewController implements IViewController
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IView $_view view object
     * @var IViewFactory $_viewFactory object that creates views
     */

    protected $_view;
    protected $_viewFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IViewFactory $viewFactory object that creates views
     */

    public function __construct(IViewFactory $viewFactory)
    {
        $this->_setValues($viewFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IViewFactory $viewFactory object that creates views
     */

    protected function _setValues(IViewFactory $viewFactory)
    {
        $this->_setViewFactory($viewFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** SET VIEW FACTORY **********/
    /**************************************/

    /**
     * @param IViewFactory $viewFactory object that creates views
     */

    protected function _setViewFactory(IViewFactory $viewFactory)
    {
        $this->_viewFactory = $viewFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET VIEW **********/
    /******************************/

    /**
     * @param IView $view view object
     */

    protected function _setView(IView $view)
    {
        $this->_view = $view;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** SET VIEW DATA **********/
    /***********************************/

    /**
     * @param Mixed $data view's data
     */

    protected function _setViewData($data)
    {
        $this->_view->setData($data);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET VIEW FACTORY **********/
    /**************************************/

    /**
     * @return IViewFactory
     */

    public function getViewFactory(): IViewFactory
    {
        return $this->_viewFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET VIEW **********/
    /******************************/

    /**
     * @return IView
     */

    public function getView(): IView
    {
        return $this->_view;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** INSTANTIATE VIEW **********/
    /**************************************/

    protected function _instantiateView()
    {
        $this->_setView($this->_viewFactory->create());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** DISPLAY **********/
    /*****************************/

    abstract public function display();
}