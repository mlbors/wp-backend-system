<?php
/**
 * WP System - FrontViewController - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ViewControllers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewFactory as IViewFactory;
use App\Theme\Abstracts\AbstractViewController as AbstractViewController;

/*******************************************/
/********** FRONT VIEW CONTROLLER **********/
/*******************************************/

class FrontViewController extends AbstractViewController
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