<?php
/**
 * WP System - MainSideFacade - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Facades;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISide as ISide;
use App\Theme\Interfaces\ISideBuilder as ISideBuilder;
use App\Theme\Abstracts\AbstractSideFacade as AbstractSideFacade;

/**************************************/
/********** MAIN SIDE FACADE **********/
/**************************************/

class MainSideFacade extends AbstractSideFacade
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param ISideBuilder $sideBuilder object that create sides
     */

    public function __construct(ISideBuilder $sideBuilder)
    {
        $this->_setValues($sideBuilder);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param ISideBuilder $sideBuilder object that create sides
     */

    private function _setValues(ISideBuilder $sideBuilder)
    {
        $this->_setSideBuilder($sideBuilder);
        $this->_setSide($this->_sideBuilder->create());
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
        return $this->_side->getSettings();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GENERATE SIDE **********/
    /***********************************/

    /**
     * @return ISide
     */

    public function generateSide(): ISide
    {
        $this->_side->init();
        return $this->_side;
    }
}