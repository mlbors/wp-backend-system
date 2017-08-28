<?php
/**
 * WP Backend System - Widget Handler
 *
 * @since       16.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Widgets;

/************************************/
/********** WIDGET HANDLER **********/
/************************************/

class WidgetHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var WidgetRegister $_widgetRegister object that registers widgets
     */

    private $_widgetRegister;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param WidgetRegister $widgetRegister object that registers widgets
     */

    public function __construct(WidgetRegister $widgetRegister)
    {
        $this->_setValues($widgetRegister);
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
     * @param WidgetRegister $widgetRegister object that registers widgets
     */

    private function _setValues(WidgetRegister $widgetRegister)
    {
        $this->setWidgetRegister($widgetRegister);
    }

    /**********/
    /********** SHORTCODE REGISTER **********/
    /**********/

    /*
     * @param WidgetRegister $widgetRegister object that registers widgets
     */

    public function setWidgetRegister(WidgetRegister $widgetRegister)
    {
        $this->_widgetRegister = $widgetRegister;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** WIDGET REGISTER **********/
    /**********/

    /*
     * @return WidgetRegister
     */

    public function getWidgetRegister(): WidgetRegister
    {
        return $this->_widgetRegister;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET UP WIDGETS **********/
    /************************************/

    public function setUpWidgets()
    {
        try {
            $this->_widgetRegister->setUpWidgets();
        } catch (\Exception $e) {
            return false;
        }
    }

}