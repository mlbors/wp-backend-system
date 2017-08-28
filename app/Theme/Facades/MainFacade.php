<?php
/**
 * WP Backend System - Main Facade
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Facades;

use App\Theme\Sides\Side as Side;

/*********************************/
/********** MAIN FACADE **********/
/*********************************/

class MainFacade implements Facade
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Side $_side object that handle the side on which the user is
     * @var Array $_settings array with theme settings and current post data
     */

    private $_side;
    private $_settings = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct(Side $side)
    {
        $this->_setValues($side);
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
     * @param Side $_side object that handle the side on which the user is
     */

    private function _setValues(Side $side)
    {
        $this->_setSide($side);
    }

    /**********/
    /********** SIDE **********/
    /**********/

    /*
     * @param Side $_side object that handle the side on which the user is
     */

    private function _setSide(Side $side)
    {
        $this->_side = $side;
    }
    
    /**********/
    /********** SETTINGS **********/
    /**********/

    /*
     * @param Array $_settings array with theme settings and current post data
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
     * @return Array
     */

    private function _getSettings(): array
    {
        return $this->_settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** GET SETTINGS FROM THEME **********/
    /*********************************************/

    /*
     * @return Array
     */

    private function _getSettingsFromTheme(): array
    {
        try {
            return $this->_side->getManager()->getTheme()->getSettings();
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** GET SETTINGS FROM MANAGER **********/
    /***********************************************/

    /*
    * @return Array
    */
 
    private function _getSettingsFromManager(): array
    {
        try {
            return $this->_side->getManager()->getSettingsHandler()->getSettings();
        } catch (\Exception $e) {
            return [];
        }
    }
 
    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** GET THEME SETTINGS **********/
    /****************************************/

    /*
    * @return Array
    */
 
    private function _getThemeSettings(): array
    {
        if (is_admin()) {
            return $this->_getSettingsFromManager();
        }

        return $this->_getSettingsFromTheme();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GET CURRENT POST DATA **********/
    /*******************************************/

    /*
     * @return Array
     */

    private function _getCurrentPostData(): array
    {
        $postGetter = $this->_side->getManager()->getPostHandler()->getPostGetter();
        $postGetter->setIdToCurrentId();

        $array['post'] = $postGetter->getPostById();
        $array['acf_fields'] = $postGetter->getPostAllAcfFields();
        $array['meta'] = $postGetter->getPostAllMeta();

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GET POST DATA **********/
    /***********************************/

    /*
     * @return Array
     */

    private function _getPostData(): array
    {
        if (is_admin()) {
            return [];
        }

        try {
            return $this->_getCurrentPostData();
        } catch (\Exception $e) {
            return [];
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*******************************************/
    /********** GET CURRENT USER DATA **********/
    /*******************************************/

    /*
     * @return Array
     */

    private function _getCurrentUserData(): array
    {
        try {
            return $this->_side->getManager()->getUserHandler()->getCurrentUserData();
        } catch (\Exception $e) {
            return [];
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** GET SETTINGS DATA **********/
    /***************************************/

    /*
     * @return Array
     */

    private function _getSettingsData(): array
    {
        $array = [];
        $array['theme_settings'] = $this->_getThemeSettings();
        $array['current_post'] = $this->_getPostData();
        $array['current_user'] = $this->_getCurrentUserData();
        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** RETRIEVE SETTINGS **********/
    /***************************************/

    public function retrieveSettings()
    {
        try {
            
            if (empty(array_filter($this->_settings))) {

                $settings = $this->_getSettingsData();
                $this->_setSettings($settings);
                return $settings;

            }

            return $this->_getSettings();

        } catch (\Exception $e) {
            return [];
        }
    }

}