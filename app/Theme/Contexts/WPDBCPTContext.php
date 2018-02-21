<?php
/**
 * WP System - WPDBCPTContext - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Contexts;

use stdClass;
use WP_Query;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Abstracts\AbstractContext as AbstractContext;
use App\Theme\Helpers\ACFFieldsHelper as ACFFieldsHelper;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;

/***************************************/
/********** WP DB CPT CONTEXT **********/
/***************************************/

class WPDBCPTContext extends AbstractContext
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
    /********** QUERY CPT **********/
    /*******************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */
    
    protected function _queryCpt($methodArgs, $queryArgs)
    {
        $result = [];
        $cpt = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-cpt', ['option_custom_post_types_labels_', 'option_custom_post_types_']);

        if (ArraysHelper::checkArray($cpt)) {
            foreach($cpt as $v => $value) {
                array_push($result, (object)$value);
            }
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** REGISTER CPT **********/
    /**********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed Bool || WP Post Type || WP Error)
     */

    protected function _registerCpt($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs)) {
            return false;
        }

        $name = (string)$queryArgs[0]->formated_name;
        $args = (array)$queryArgs[0];
        unset($args['formated_name']);

        $register = add_action('init', function() use($name, $args) { 
            register_post_type($name, $args);
        });

        return $register;
    }
}