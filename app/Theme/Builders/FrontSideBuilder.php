<?php
/**
 * WP System - FrontSideBuilder - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISide as ISide;
use App\Theme\Abstracts\AbstractSideBuilder as AbstractSideBuilder;
use App\Theme\Builders\FrontManagerBuilder as FrontManagerBuilder;
use App\Theme\Sides\FrontSide as FrontSide;

/****************************************/
/********** FRONT SIDE BUILDER **********/
/****************************************/

class FrontSideBuilder extends AbstractSideBuilder
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
            $this->_container->make(FrontManagerBuilder::class),
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
        return $this->_container->makeWith(FrontSide::class, ['managerBuilders' => $this->_managerBuilders]);
    }
}