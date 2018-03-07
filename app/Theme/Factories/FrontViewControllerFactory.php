<?php
/**
 * WP System - FrontViewControllerFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewController as IViewController;
use App\Theme\Interfaces\IViewFactory as IViewFactory;
use App\Theme\Abstracts\AbstractViewControllerFactory as AbstractViewControllerFactory;
use App\Theme\Factories\FrontViewFactory as FrontViewFactory;
use App\Theme\ViewControllers\FrontViewController as FrontViewController;

/***************************************************/
/********** FRONT VIEW CONTROLLER FACTORY **********/
/***************************************************/

class FrontViewControllerFactory extends AbstractViewControllerFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IViewFactory $_viewFactory object that creates views
     */

    protected $_viewFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
        $this->_setViewFactory();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** SET VIEW FACTORY **********/
    /**************************************/

    protected function _setViewFactory()
    {
        $this->_viewFactory = $this->_container->make(FrontViewFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** CREATE VIEW CONTROLLER **********/
    /********************************************/

    /**
     * @return IViewController
     */

    protected function _createViewController(): IViewController
    {
        return $this->_container->makeWith(FrontViewController::class, ['viewFactory' => $this->_viewFactory]);
    }
}