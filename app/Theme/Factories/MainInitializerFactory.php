<?php
/**
 * WP System - MainInitializerFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IInitializer as IInitializer;
use App\Theme\Interfaces\ISideFacadeFactory as ISideFacadeFactory;
use App\Theme\Abstracts\AbstractInitializerFactory as AbstractInitializerFactory;
use App\Theme\Factories\MainSideFacadeFactory as MainSideFacadeFactory;
use App\Theme\Initializers\MainInitializer as MainInitializer;

/**********************************************/
/********** MAIN INITIALIZER FACTORY **********/
/**********************************************/

class MainInitializerFactory extends AbstractInitializerFactory
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

    /*********************************************/
    /********** SET SIDE FACADE FACTORY **********/
    /*********************************************/

    /**
     * @param Container $container app container
     */

    protected function _setSideFacadeFactory()
    {
        $this->_sideFacadeFactory = $this->_container->make(MainSideFacadeFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CREATE INITIALIZER **********/
    /****************************************/

    /**
     * @return IInitializer
     */

    protected function _createInitializer(): IInitializer
    {
        return $this->_container->makeWith(MainInitializer::class, ['sideFacadeFactory' => $this->_sideFacadeFactory]);
    }
}