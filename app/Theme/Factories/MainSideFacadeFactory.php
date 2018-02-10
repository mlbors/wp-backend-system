<?php
/**
 * WP System - MainSideFacadeFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISideFacadeFactory as ISideFacadeFactory;
use App\Theme\Interfaces\ISideFacade as ISideFacade;
use App\Theme\Interfaces\ISideBuilder as ISideBuilder;
use App\Theme\Abstracts\AbstractSideFacadeFactory as AbstractSideFacadeFactory;
use App\Theme\Facades\MainSideFacade as MainSideFacade;
use App\Theme\Builders\BackSideBuilder as BackSideBuilder;
use App\Theme\Builders\FrontSideBuilder as FrontSideBuilder;

/*****************************************/
/********** MAIN FACADE FACTORY **********/
/*****************************************/

class MainSideFacadeFactory extends AbstractSideFacadeFactory
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

    /**************************************/
    /********** SET SIDE BUILDER **********/
    /**************************************/

    protected function _setSideBuilder()
    {
        if (is_admin()) {
            $this->_sideBuilder = $this->_container->make(BackSideBuilder::class);
            return;
        }

        $this->_sideBuilder = $this->_container->make(FrontSideBuilder::class);
        return;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** CREATE FACADE **********/
    /***********************************/

    /**
     * @return ISideFacade
     */

    protected function _createFacade(): ISideFacade
    {
        return $this->_container->makeWith(MainSideFacade::class, ['sideBuilder' => $this->_sideBuilder]);
    }
}