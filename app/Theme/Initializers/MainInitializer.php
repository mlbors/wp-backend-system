<?php
/**
 * WP Backend System - Initializer
 *
 * @since       31.07.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Initializers;

use \App\Theme\Sides\FrontSideFactory as FrontSideFactory;
use \App\Theme\Sides\BackSideFactory as BackSideFactory;
use \App\Theme\Facades\MainFacadeFactory as MainFacadeFactory;

/**************************************/
/********** INITIALIZER MAIN **********/
/**************************************/

final class MainInitializer implements Initializer
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**********/
    /********** PRIVATE **********/
    /**********/

    /*
     * @var SideFactory $_sideFactory object that creates side
     * @var Side $_side object that handle the side on which the user is
     * @var FacadeFactory $_facadeFacotry object that creates facade
     * @var Facade $_facade object that retrieves and manage settings to use same easily in other parts of the theme
     * @var Array $_settings array of settings fill in Facade
     */

    private $_sideFactory;
    private $_side;
    private $_facadeFacotry;
    private $_facade;
    private $_settings;

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
    /*********/

    private function _setValues() 
    {
        $this->_setSideFactory();
        $this->_setSide();
        $this->_setFacadeFactory();
        $this->_setFacade();
    }

    /**********/
    /********** SIDE FACTORY **********/
    /*********/

    private function _setSideFactory()
    {
        if (is_admin()) {
            $this->_sideFactory = new BackSideFactory();
        } else {
            $this->_sideFactory = new FrontSideFactory();
        }      
    }

    /**********/
    /********** SIDE **********/
    /*********/

    private function _setSide()
    {
        $this->_side = $this->_sideFactory->createSide();
    }

    /**********/
    /********** FACADE FACTORY **********/
    /*********/

    private function _setFacadeFactory()
    {
        $this->_facadeFactory = new MainFacadeFactory();     
    }

    /**********/
    /********** FACADE **********/
    /*********/

    private function _setFacade()
    {
        $this->_facade = $this->_facadeFactory->create($this->_side);
    }

    /**********/
    /********** SETTINGS **********/
    /*********/

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

    public function getSettings(): array
    {
        return $this->_settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** RETRIEVE SETTINGS **********/
    /***************************************/

    public function retrieveSettings()
    {
        $this->_setSettings($this->_facade->retrieveSettings()); 
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    /*
     * @return Bool
     */

    public function init(): bool
    {
        try {
            $this->_side->generate(); 
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}