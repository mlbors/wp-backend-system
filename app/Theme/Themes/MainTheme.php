<?php
/**
 * WP Backend System - Main Theme
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Themes;

/********************************/
/********** MAIN THEME **********/
/********************************/

class MainTheme implements Theme
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Array settings theme's settings
     */

    private $_settings = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param Array settings theme's settings
     */

    public function __construct(Builder $builder)
    {
        $this->_setValues($builder->getSettings());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    /*
     * @param Array settings theme's settings
     */

    private function _setValues(array $settings)
    {
        $this->_setSettings($settings);
    }

    /**********/
    /********** SETTINGS **********/
    /**********/

    /*
     * @param Array settings theme's settings
     */

    private function _setSettings(array $settings)
    {
        $this->_settings = $settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** SETTINGS **********/
    /**********/

    /*
     * @return array
     */

    public function getSettings(): array
    {
        return $this->_settings;
    }

}