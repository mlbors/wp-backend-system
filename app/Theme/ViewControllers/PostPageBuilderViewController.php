<?php
/**
 * WP System - PostPageBuilderViewController - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ViewControllers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewFactory as IViewFactory;
use App\Theme\Abstracts\AbstractPostPageBuilderViewController as AbstractPostPageBuilderViewController;

/*******************************************************/
/********** POST PAGE BUILDER VIEW CONTROLLER **********/
/*******************************************************/

class PostPageBuilderViewController extends AbstractPostPageBuilderViewController
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IViewFactory $viewFactory object that creates views
     */

    public function __construct(IViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** DISPLAY **********/
    /*****************************/

    public function display()
    {
        return $this->_view->render();
    }
}