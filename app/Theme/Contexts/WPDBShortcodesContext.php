<?php
/**
 * WP System - WPDBShortcodesContext - Concrete Class
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

/**********************************************/
/********** WP DB SHORTCODES CONTEXT **********/
/**********************************************/

class WPDBShortcodesContext extends AbstractContext
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

    /*************************************/
    /********** QUERY SHORTCODE **********/
    /*************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */

    protected function _queryShortcode($methodArgs, $queryArgs)
    {
        $result = [];
        $shortcodes = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-shortcodes', ['custom_shortcodes_post_lists_', 'custom_shortcodes_display_post_', 'custom_shortcodes_display_text_', 'custom_shortcodes_display_view_', 'custom_shortcodes_display_image_', 'custom_shortcodes_display_gallery_', 'custom_shortcodes_', 'custom_shotcodes_']);
        
        if (ArraysHelper::checkArray($shortcodes)) {
            foreach($shortcodes as $s => $shortcode) {
                array_push($result, (object)$shortcode);
            }
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** REGISTER SHORTCODE **********/
    /****************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return
     */

    protected function _registerShortcode($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['shortcode'])) {
            return false;
        }

        $queryArgs['shortcode']->register();
        return;
    }
}