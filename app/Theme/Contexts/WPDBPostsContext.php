<?php
/**
 * WP System - WPDBPostsContext - Concrete Class
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

/*****************************************/
/********** WP DB POSTS CONTEXT **********/
/*****************************************/

class WPDBPostsContext extends AbstractContext
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

    /********************************/
    /********** QUERY POST **********/
    /********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return WP Post
     */

    protected function _queryPost($methodArgs, $queryArgs)
    {
        if ($methodArgs['method'] === "get") {
            return get_posts($queryArgs['args']);
        }

        if ($methodArgs['use_theme_object']) {
            $query = new WP_Query($queryArgs['args']);
            return $query->posts;
        }

        return new WP_Query($queryArgs['args']);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** QUERY POST CURRENT **********/
    /****************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return WP Post
     */

    protected function _queryPostCurrent($methodArgs, $queryArgs)
    {
        global $post;
        return $post;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** QUERY POST BY ID **********/
    /**************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed WP Post || False
     */

    protected function _queryPostByID($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs)) {
            return false;
        }

        return get_post($queryArgs);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** UPDATE POST **********/
    /*********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed WP Post || WP Error
     */

    protected function _updatePost($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['ID'])) {
            return false;
        }

        $update = wp_update_post($queryArgs, true);
        return is_wp_error($update) ? $update : get_post($queryArgs['ID']);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** UPDATE POST META ACF **********/
    /******************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed WP Post || WP Error
     */

    protected function _updatePostMetaACF($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['ID'])) {
            return false;
        }

        foreach ($queryArgs['data'] as $key => $item) {
            
            if (!empty($item['name'])) {
                
                $field = get_field($item['name'], $queryArgs['ID']);
            
                if ($field != $item['value']) {
                    update_field($key, $item['value'], $queryArgs['ID']);
                }
                
            }

        }

        return get_post($queryArgs['ID']);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** CHECK POST **********/
    /********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed WP Post || False
     */

    protected function _checkPost($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['ID'])) {
            return false;
        }

        return get_post($queryArgs['ID'], OBJECT);
    }
}