<?php
/**
 * WP System - WPDBTaxonomiesContext - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Contexts;

use WP_Query;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Abstracts\AbstractContext as AbstractContext;

/**********************************************/
/********** WP DB TAXONOMIES CONTEXT **********/
/**********************************************/

class WPDBTaxonomiesContext extends AbstractContext
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntityFactory $entityFactory object that create entities
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IEntityFactory $entityFactory, string $requestService)
    {
        parent::__construct($entityFactory, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** QUERY TAXONOMY **********/
    /************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed
     */

    protected function _queryTaxonomy($methodArgs, $queryArgs)
    {
        return get_taxonomies($queryArgs['args'], $methodArgs['output'], $methodArgs['operator']);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** QUERY TAXONOMY BY NAME **********/
    /********************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Object
     */

    protected function _queryTaxonomyByName($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['name'])) {
            return false;
        }

        return get_taxonomy($queryArgs['name']);
    }
}