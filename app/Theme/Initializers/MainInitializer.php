<?php
/**
 * WP System - MainInitializer - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Initializers;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractInitializer as AbstractInitializer;
use App\Theme\Interfaces\ISideFacadeFactory as ISideFacadeFactory;

/**************************************/
/********** MAIN INITIALIZER **********/
/**************************************/

class MainInitializer extends AbstractInitializer
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param ISideFacadeFactory $sideFacadeFactory object that creates facades 
     */

    public function __construct(ISideFacadeFactory $sideFacadeFactory)
    {
        $this->_setValues($sideFacadeFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param ISideFacadeFactory $sideFacadeFactory object that creates facades 
     */

    private function _setValues(ISideFacadeFactory $sideFacadeFactory)
    {
        $container = Container::getInstance();
        $this->_setSideFacadeFactory($sideFacadeFactory);
        $this->_setSideFacade($this->_sideFacadeFactory->create());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        $this->_sideFacade->generateSide();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET SETTINGS **********/
    /**********************************/

    /**
     * @return Array
     */

    public function getSettings(): array {
        $this->_setSettings($this->_sideFacade->getSettings());
        return $this->_settings;
    }
}