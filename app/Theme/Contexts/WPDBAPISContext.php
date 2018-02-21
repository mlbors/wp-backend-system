<?php
/**
 * WP System - WPDBAPISContext - Concrete Class
 *
 * @since       12.01.2018
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
use App\Theme\Helpers\ACFFieldsHelper as ACFFieldsHelper;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;

/****************************************/
/********** WP DB APIS CONTEXT **********/
/****************************************/

class WPDBAPISContext extends AbstractContext
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

    /*******************************/
    /********** QUERY API **********/
    /*******************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */

    protected function _queryApi($methodArgs, $queryArgs)
    {
        $result = [];
        $apis = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-apis', ['custom_apis_']);

        if (ArraysHelper::checkArray($apis)) {
            foreach($apis as $a => $api) {
                if (!empty($api)) {
                    array_push($result, (object)['name' => $a, 'value' => $api]);
                }
            }
        }

        return $result;
    }
}