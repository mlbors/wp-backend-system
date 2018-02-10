<?php
/**
 * WP System - WPDBOptionsContext - Concrete Class
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

/*******************************************/
/********** WP DB OPTIONS CONTEXT **********/
/*******************************************/

class WPDBOptionsContext extends AbstractContext
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

    /**********************************/
    /********** QUERY OPTION **********/
    /**********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */

    protected function _queryOption($methodArgs, $queryArgs)
    {
        $result = [];
        $options = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-options', ['custom_options_add_mimes_','custom_options_add_image_sizes_','custom_options_options_', 'custom_options_']);
        
        foreach($options as $o => $option) {

            if ($o === 'hide_menus_to_users' && $options['hide_menus_to_users_bool'] && !empty($option)) {
                array_push($result, (object)['type' => $o, 'value' => $option]);
            } elseif ($o === 'hide_options_to_users' && $options['hide_options_to_users_bool'] && !empty($option)) {
                array_push($result, (object)['type' => $o, 'value' => $option]);
            } elseif ($option && $o !== 'hide_menus_to_users_bool' && $o !== 'hide_options_to_users_bool') {
                array_push($result, (object)['type' => $o, 'value' => $option]);
            }
        }
        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** APPLY OPTION **********/
    /**********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return
     */

    protected function _applyOption($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['option'])) {
            return false;
        }

        $queryArgs['option']->apply();
        return;
    }
}