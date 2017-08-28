<?php
/**
 * WP Backend System - Shortcode Handler
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Shortcodes;

use App\Theme\Posts\PostGetter as PostGetter;
use App\Theme\Taxonomies\TaxonomyGetter as TaxonomyGetter;

/***************************************/
/********** SHORTCODE HANDLER **********/
/***************************************/

class ShortcodeHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var ShortcodeRegister $_shortcodeRegister object that registers shortcodes
     */

    private $_shortcodeRegister;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param ShortcodeRegister $shortcodeRegister object that registers shortcodes
     */

    public function __construct(ShortcodeRegister $shortcodeRegister)
    {
        $this->_setValues($shortcodeRegister);
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
     * @param ShortcodeRegister $_shortcodeRegister object that registers shortcodes
     */

    private function _setValues(ShortcodeRegister $shortcodeRegister)
    {
        $this->setShortcodeRegister($shortcodeRegister);
    }

    /**********/
    /********** SHORTCODE REGISTER **********/
    /**********/

    /*
     * @param ShortcodeRegister $_shortcodeRegister object that registers shortcodes
     */

    public function setShortcodeRegister(ShortcodeRegister $shortcodeRegister)
    {
        $this->_shortcodeRegister = $shortcodeRegister;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** SHORTCODE REGISTER **********/
    /**********/

    /*
     * @return ShortcodeRegister
     */

    public function getShortcodeRegister(): ShortcodeRegister
    {
        return $this->_shortcodeRegister;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** CREATE SHORTCODES **********/
    /***************************************/

    public function createShortcodes()
    {
        try {
            $this->_shortcodeRegister->setUpShortcodes();
        } catch (\Exception $e) {
            return false;
        }
    }

}