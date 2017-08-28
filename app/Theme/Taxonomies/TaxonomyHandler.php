<?php
/**
 * WP Backend System - Taxonomy Handler
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Taxonomies;

/**************************************/
/********** TAXONOMY HANDLER **********/
/**************************************/

class TaxonomyHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var TaxonomyGetter $_taxonomyGetter object that gets taxonomies
     * @var TaxonomyCreator $_customTaxonomyCreator object that creates taxonomies
     */

    private $_taxonomyGetter;
    private $_customTaxonomyCreator;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param TaxonomyGetter $taxonomyGetter object that gets taxonomies
     * @param TaxonomyCreator $customTaxonomyCreator object that creates taxonomies
     */

    public function __construct(TaxonomyGetter $taxonomyGetter, TaxonomyCreator $customTaxonomyCreator)
    {
        $this->_setValues($taxonomyGetter, $customTaxonomyCreator);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    /*
     * @param TaxonomyGetter $taxonomyGetter object that gets taxonomies
     * @param TaxonomyCreator $customTaxonomyCreator object that creates taxonomies
     */

    private function _setValues(TaxonomyGetter $taxonomyGetter, TaxonomyCreator $customTaxonomyCreator)
    {
        $this->setTaxonomyGetter($taxonomyGetter);
        $this->setCustomTaxonomyCreator($customTaxonomyCreator);
    }

    /**********/
    /********** TAXONOMY GETTER **********/
    /**********/

    /*
     * @param TaxonomyGetter $taxonomyGetter object that gets taxonomies
     */

    public function setTaxonomyGetter(TaxonomyGetter $taxonomyGetter)
    {
        $this->_taxonomyGetter = $taxonomyGetter;
    }

    /**********/
    /********** CUSTOM TAXONOMY CREATOR **********/
    /**********/

    /*
     * @param TaxonomyCreator $customTaxonomyCreator object that creates taxonomies
     */

    public function setCustomTaxonomyCreator(TaxonomyCreator $customTaxonomyCreator)
    {
        $this->_customTaxonomyCreator = $customTaxonomyCreator;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** TAXONOMY GETTER **********/
    /**********/

    /*
     * @return TaxonomyGetter
     */

    public function getTaxonomyGetter(): TaxonomyGetter
    {
        return $this->_taxonomyGetter;
    }

    /**********/
    /********** CUSTOM TAXONOMY CREATOR **********/
    /**********/

    /*
     * @return TaxonomyCreator
     */

    public function getTaxonomyCreator(): TaxonomyCreator
    {
        return $this->_customTaxonomyCreator;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** SET CUSTOM TAXONOMIES **********/
    /*******************************************/

    public function setCustomTaxonomies()
    {
        try {
            $this->_customTaxonomyCreator->setCustomTaxonomies();
        } catch (\Exception $e) {
            return false;
        }
    }

}