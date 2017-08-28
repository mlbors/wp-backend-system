<?php
/**
 * WP Backend System - Main Taxonomy Getter
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Taxonomies;

/******************************************/
/********** MAIN TAXONOMY GETTER **********/
/******************************************/

class MainTaxonomyGetter implements TaxonomyGetter
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Array $_args query args
     * @var Mixed $_taxonomies targeted taxonomies
     * @var Int $_termId term id
     * @var Int $_taxonomyId taxonomy id
     * @var Int $_postId post id
     */

    private $_args = [];
    private $_taxonomies = null;
    private $_termId = null;
    private $_taxonomyId = null;
    private $_postId = null;

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

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** ARGS **********/
    /**********/

    /*
     * @param Array $args query args
     */

    public function setArgs(array $args)
    {
        $this->_args = $args;
    }

    /**********/
    /********** TAXONOMIES **********/
    /**********/

    /*
     * @param Mixed $_taxonomies targeted taxonomies
     */

    public function setTaxonomies($taxonomies)
    {
        $this->_taxonomies = $taxonomies;
    }

    /**********/
    /********** TERM ID **********/
    /**********/

    /*
     * @param Int $termId term id
     */

    public function setTermId($termId)
    {
        $this->_termId = $termId;
    }

    /**********/
    /********** TAXONOMY ID **********/
    /**********/

    /*
     * @param Int $taxonomyId taxonomy id
     */

    public function setTaxonomyId($taxonomyId)
    {
        $this->_taxonomyId = $taxonomyId;
    }

    /**********/
    /********** POST ID **********/
    /**********/

    /*
     * @param Int $postId post id
     */

    public function setId(int $postId)
    {
        $this->_postId = $postId;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET TAX ELEMENTS **********/
    /**************************************/

    public function getTaxElements()
    {
        $terms = get_terms($this->_taxonomies, $this->_args);
        return $terms;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET POST TAXONOMIES **********/
    /*****************************************/

    /*
     * @return Mixed Object || false
     */

    public function getPostTaxonomies()
    {
        if (empty($this->_postId)) {
            return false;
        }

        $post = get_post($this->_postId, OBJECT);

        if (empty($post)) {
            return false;
        }

        $taxonomies = get_object_taxonomies($post);

        if (!empty($taxonomies)) {
            return $taxonomies;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** GET TERMS ASSOCIATIVE ARRAY **********/
    /*************************************************/

    /*
     * @return Mixed Array || false
     */

    public function getTermsAssocArray()
    {
        $array = [];
        $terms = $this->getTaxElements();

        if (empty($terms) || is_wp_error($terms) || !is_array($terms)) {
            return false;
        }

        foreach($terms as $term) {
            $array[$term->slug] = $term->slug;
        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** GET POST TERMS **********/
    /************************************/

    /*
     * @param String $kind kind of return value
     * @param String $seperator used when $kind is String
     * @return Mixed String || Array || false
     */

    public function getPostTerms($kind = 'OBJ', $sepeartor = ',')
    {
        if (empty($this->_taxonomies) || !is_string($this->_taxonomies) || empty($this->_postId)) {
            return false;
        }

        $terms = wp_get_post_terms($this->_postId, $this->_taxonomies);

        if (empty($terms) || !is_wp_error($terms)) {
            return false;
        }

        $output = '';

        switch ($kind) {
            
            case 'OBJ':

                $output = $terms;
                break;
            
            case 'STR':
            
                $str = '';
            
                $i = 1;

                foreach ($terms as $term) {

                    $str .= $term->name;

                    if ($i < count($terms)) {
                        $str .= ' ' . $separator . ' ';
                    }

                    $i++;

                }
            
                $output = $str;
                break;
            
            default:
            
                $output = $terms;
                break;
            
        }

        return $output;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** GET TOTAL POSTS IN CATEGORY **********/
    /*************************************************/

    /*
     * @return Int
     */

    public function getTotalPostsInCategory()
    {
        $count = 0;
        $categories = get_categories($this->_args);
        
        foreach($categories as $category) {
            $count += $category->count;
        }
        
        return $count;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET TERM ID BY SLUG **********/
    /*****************************************/

    /*
     * @param String $slug term slug
     * @return Mixed Object || false
     */

    public function getTermBySlug($slug)
    {
        if (empty($slug) || empty($this->_taxonomies) || !is_string($this->_taxonomies)) {
            return false;
        }

        $term = get_term_by('slug', $slug, $this->_taxonomies);

        if (!empty($term)) {
            return $termn;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET TERM ID BY NAME **********/
    /*****************************************/

    /*
     * @param String $name term name
     * @return Mixed Object || false
     */

    public function getTermByName($name)
    {
        if (empty($name) || empty($this->_taxonomies) || !is_string($this->_taxonomies)) {
            return false;
        }

        $term = get_term_by('name', $name, $this->_taxonomies);

        if (!empty($term)) {
            return $term;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** GET TERM BY ID **********/
    /************************************/

    /*
     * @return Mixed Object || false
     */

    public function getTermById()
    {
        if (empty($this->_termId) || empty($this->_taxonomies) || !is_string($this->_taxonomies)) {
            return false;
        }

        $term = get_term_by('id', $this->_termId, $this->_taxonomies);

        if (!empty($term)) {
            return $term;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** GET TERM CHILDS **********/
    /*************************************/

    /*
     * @param String $kind return kind value
     * @param String $separator used when $kind is String
     * @param String $property used when $kind is String
     * @return Mixed Object || false
     */

    public function getTermChilds(&$kind = "ARRAY", $separator = ",", $property = "slug")
    {
        if (empty($this->_termId) || empty($this->_taxonomies) || !is_string($this->_taxonomies)) {
            return false;
        }

        $children = get_term_children($this->_termId, $this->_taxonomies);

        if (empty( $children)) {
            return false;
        }

        $output = '';
        $kind = strtoupper($kind);
        
        switch($kind) {
                
            case 'ARRAY':
                $output = $children;
                break;
            
            case 'STRING':
                
                $str = '';
                
                $count = count($children);
                $cpt = 1;
                
                foreach($children as $term) {
                    
                    $termObj = get_term_by('id', $term, $this->_taxonomies, 'OBJECT');
                    $str .= ( string )$termObj->$property;
                    
                    if ( $cpt < $count ) {
                        $str .= $separator;
                    }
                    
                    $cpt++;

                }
                
                $output = $str;
                break;
                
            default:
                $output = $children;
                break;
            
        }
        
        return $output;
    }

}