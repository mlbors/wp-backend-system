<?php
/**
 * WP System - WPDBWidgetsContextFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Abstracts\AbstractContextFactory as AbstractContextFactory;
use App\Theme\Contexts\WPDBWidgetsContext as WPDBWidgetsContext;

/**************************************************/
/********** WPDB WIDGETS CONTEXT FACTORY **********/
/**************************************************/

class WPDBWidgetsContextFactory extends AbstractContextFactory
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntityFactory $entityFactory object that creates entities
     */

    public function __construct(IEntityFactory $entityFactory)
    {
        parent::__construct($entityFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE CONTEXT **********/
    /************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     * @return IContext
     */

    protected function _createContext(string $requestService): IContext
    {
        return $this->_container->makeWith(WPDBWidgetsContext::class, ['entityFactory' => $this->_entityFactory, 'requestService' => $requestService]);
    }
}