<?php
/**
 * WP Backend System - Handler Factory - Interface
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

/*************************************/
/********** HANDLER FACTORY **********/
/*************************************/

interface HandlerFactory
{
    public function create(PostGetter $postGetter, TaxonomyGetter $taxonomyGetter, TransientOperator $transientOperator): Handler;
}