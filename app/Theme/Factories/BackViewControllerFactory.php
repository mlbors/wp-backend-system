<?php
/**
 * WP System - BackViewControllerFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewControllerFactory as IViewControllerFactory;
use App\Theme\Interfaces\IViewController as IViewController;
use App\Theme\Abstracts\AbstractViewControllerFactory as AbstractViewControllerFactory;
use App\Theme\ViewControllers\BackViewController as BackViewController;

/**************************************************/
/********** BACK VIEW CONTROLLER FACTORY **********/
/**************************************************/

class BackViewControllerFactory extends AbstractViewControllerFactory
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
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
        return $this->_container->make(BackViewController::class);
    }
}