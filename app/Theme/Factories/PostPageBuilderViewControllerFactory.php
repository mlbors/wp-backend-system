<?php
/**
 * WP System - PostPageBuilderViewControllerFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewController as IViewController;
use App\Theme\Interfaces\IViewFactory as IViewFactory;
use App\Theme\Abstracts\AbstractViewControllerFactory as AbstractViewControllerFactory;
use App\Theme\Factories\PageBuilderViewFactory as PageBuilderViewFactory;
use App\Theme\ViewControllers\PostPageBuilderViewController as PostPageBuilderViewController;

/***************************************************************/
/********** POST PAGE BUILDER VIEW CONTROLLER FACTORY **********/
/***************************************************************/

class PostPageBuilderViewControllerFactory extends AbstractViewControllerFactory
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
        $this->_viewFactory = $this->_container->make(PageBuilderViewFactory::class);
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
        return $this->_container->makeWith(PostPageBuilderViewController::class, ['viewFactory' => $this->_viewFactory]);
    }
}