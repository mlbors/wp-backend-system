<?php
/**
 * WP System - Theme
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\ITheme as ITheme;
use App\Theme\Interfaces\IInitializer as IInitializer;
use App\Theme\Interfaces\IInitializerFactory as IInitializerFactory;

/************************************/
/********** ABSTRACT THEME **********/
/************************************/

abstract class AbstractTheme implements ITheme
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Array $_settings array of settings
     * @var IInitializer $_initializer initializer object
     * @var IInitializerFactory $_initializerFactory object that creates initializers
     */

    protected $_settings = [];
    protected $_initializer;
    protected $_initializerFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    /**
     * @return Mixed IInitializer || false
     */

    public function init()
    {
        try {
            $this->_initializer->init();
            return $this->_initializer;
        } catch (\Exception $e) {
            return false;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SET SETTINGS **********/
    /**********************************/

    /**
     * @param Array $settings array of settings
     */

    protected function _setSettings($settings)
    {
        $this->_settings = $settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** SET INITIALIZER **********/
    /*************************************/

    /**
     * @param IInitializer $initializer initializer object
     */

    protected function _setInitializer(IInitializer $initializer)
    {
        $this->_initializer = $initializer;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** SET INITIALIZER FACTORY **********/
    /*********************************************/

    /**
     * @param IInitializerFactory $initializerFactory object that creates initializers
     */

    protected function _setInitializerFactory(IInitializerFactory $initializerFactory)
    {
        $this->_initializerFactory = $initializerFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET GLOBAL SETTINGS **********/
    /*****************************************/

    public function setGlobalSettings() {
        add_action('wp', function() {
            $currentSettings = $this->_initializer->getSettings();
            $this->_setSettings($currentSettings);

            global $settings;
            $settings = $this->_settings;
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET SETTINGS **********/
    /**********************************/

    /**
     * @return Array
     */

    public function getSettings(): array
    {
        return $this->_settings;
    }
}