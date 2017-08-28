<?php
/**
 * WP Backend System - Handler - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Taxonomies;

/*****************************/
/********** HANDLER **********/
/*****************************/

interface Handler
{
    public function setTaxonomyGetter(TaxonomyGetter $taxonomyGetter);
    public function setCustomTaxonomyCreator(TaxonomyCreator $customTaxonomyCreator);
    public function getTaxonomyGetter(): TaxonomyGetter;
    public function getTaxonomyCreator(): TaxonomyCreator;
}