<?php
/**
 * WP Backend System - Theme Builder
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Themes;

use \App\Theme\Posts\PostGetter as PostGetter;
use \App\Theme\Settings\SettingsHandlerFactory as SettingsHandlerFactory;
use \App\Theme\Settings\SettingsHandler as SettingsHandler;

/********************************/
/********** MAIN THEME **********/
/********************************/

class ThemeBuilder implements Builder
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var SettingsHandler $_settingsHandler object that handles theme settings
     * @var Array settings theme's settings
     */

    private $_settingsHandler;
    private $_settings = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        $this->_setValues();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    private function _setValues()
    {
        $this->_setSettingsHandler();
        $this->_setSettings();
    }

    /**********/
    /********** SETTINGS HANDLER **********/
    /**********/

    private function _setSettingsHandler()
    {
        $this->_settingsHandler = (new SettingsHandlerFactory())->create();
    }

    /**********/
    /********** SETTINGS **********/
    /**********/

    private function _setSettings()
    {
        $this->_settingsHandler->init();
        $this->_settings = $this->_settingsHandler->getSettings();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    public function getSettings(): array
    {
        return $this->_settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************/
    /********** BUILD **********/
    /***************************/

    public function build(): Theme
    {
        return new MainTheme($this);
    }

}