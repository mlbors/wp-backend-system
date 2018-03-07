<?php
/**
 * WP System - WPDBCTContext - Concrete Class
 *
 * @since       2018.01.12
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
/********** WP DB CT CONTEXT **********/
/***************************************/

class WPDBCTContext extends AbstractContext
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

    /******************************/
    /********** QUERY CT **********/
    /******************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */
    
    protected function _queryCt($methodArgs, $queryArgs)
    {
        $result = [];
        $ct = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-taxonomies', ['option_custom_taxonomies_labels_', 'option_custom_taxonomies_']);

        if (ArraysHelper::checkArray($ct)) {
            foreach($ct as $v => $value) {
                array_push($result, (object)$value);
            }
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** REGISTER CT **********/
    /*********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed Bool || WP Post Type || WP Error)
     */

    protected function _registerCt($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs)) {
            return false;
        }

        $name = (string)$queryArgs[0]->formated_name;
        $postType = (string)$queryArgs[0]->post_type;
        $args = (array)$queryArgs[0];

        unset($args['formated_name']);
        unset($args['post_type']);

        $register = add_action('init', function() use($name, $postType, $args) { 
            register_taxonomy($name, $postType, $args);
        });

        return $register;
    }
}