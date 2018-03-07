<?php
/**
 * WP System - MainInitializer - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Initializers;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractInitializer as AbstractInitializer;
use App\Theme\Interfaces\ISideFacadeFactory as ISideFacadeFactory;
use App\Theme\Helpers\PluginsHelper as PluginsHelper;

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
        if (!PluginsHelper::checkClass('ACF')) {
            throw new \Exception('ACF is not available.');
        }
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