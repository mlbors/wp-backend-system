<?php
/**
 * WP Backend System - Shortcode Handler Factory
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Shortcodes;

use App\Theme\Posts\PostGetter as PostGetter;
use App\Theme\Taxonomies\TaxonomyGetter as TaxonomyGetter;
use \App\Theme\Transients\TransientOperator as TransientOperator;

/***********************************************/
/********** SHORTCODE HANDLER FACTORY **********/
/***********************************************/

class ShortcodeHandlerFactory implements HandlerFactory
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /*
     * @param PostGetter $postGetter object that gets posts
     * @param TaxonomyGetter $taxonomyGetter object that gets taxonomies
     * @param TransientOperator $transientOperator object that handles transients
     * @return Handler
     */

    public function create(PostGetter $postGetter, TaxonomyGetter $taxonomyGetter, TransientOperator $transientOperator): Handler
    {
        return new ShortcodeHandler(new MainShortcodeRegister($postGetter, $taxonomyGetter, $transientOperator));
    }

    /*********************************************************************************/
    /*********************************************************************************/

}