<?php
/**
 * WP System - AbstractSideFacade - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISideFacade as ISideFacade;
use App\Theme\Interfaces\ISide as ISide;
use App\Theme\Interfaces\ISideBuilder as ISideBuilder;

/******************************************/
/********** ABSTRACT SIDE FACADE **********/
/******************************************/

abstract class AbstractSideFacade implements ISideFacade
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var ISide $_side side object
     * @var ISideBuilder $_sideBuilder object that creates sides
     */

    protected $_side;
    protected $_sideBuilder;

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET SIDE **********/
    /******************************/

    /**
     * @param ISide $side side object
     */

    protected function _setSide(ISide $side)
    {
        $this->_side = $side;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** SET SIDE BUILDER **********/
    /**************************************/

    /**
     * @param ISideBuilder $sideBuilder object that creates sides
     */

    protected function _setSideBuilder(ISideBuilder $sideBuilder)
    {
        $this->_sideBuilder = $sideBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET SIDE **********/
    /******************************/

    /**
     * @return ISide
     */

    public function getSide(): ISide
    {
        return $this->_side;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET SIDE BUILDER **********/
    /**************************************/

    /**
     * @return ISideBuilder
     */

    public function getSideBuilder(): ISideBuilder
    {
        return $this->_sideBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET SETTINGS **********/
    /**********************************/

    /**
     * @return Array
     */

    abstract public function getSettings(): array;

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GENERATE SIDE **********/
    /***********************************/

    /**
     * @return ISide
     */

    abstract public function generateSide(): ISide;
}