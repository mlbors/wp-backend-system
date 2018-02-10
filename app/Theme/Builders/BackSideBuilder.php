<?php
/**
 * WP System - BackSideBuilder - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISide as ISide;
use App\Theme\Abstracts\AbstractSideBuilder as AbstractSideBuilder;
use App\Theme\Builders\BackManagerBuilder as BackManagerBuilder;
use App\Theme\Sides\BackSide as BackSide;

/***************************************/
/********** BACK SIDE BUILDER **********/
/***************************************/

class BackSideBuilder extends AbstractSideBuilder
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** SET MANAGER BUILDERS **********/
    /******************************************/

    protected function _setManagerBuilders()
    {
        $this->_managerBuilders = [
            $this->_container->make(BackManagerBuilder::class)
        ];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** CREATE SIDE **********/
    /*********************************/

    /**
     * @return ISide
     */

    protected function _createSide(): ISide
    {
        return $this->_container->makeWith(BackSide::class, ['managerBuilders' => $this->_managerBuilders]);
    }
}