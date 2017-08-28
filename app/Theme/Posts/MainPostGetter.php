<?php
/**
 * WP Backend System - Main Post Getter
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Posts;

use WP_Query;

/**************************************/
/********** MAIN POST GETTER **********/
/**************************************/

class MainPostGetter implements PostGetter
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Array $_args query args
     * @var Int $_id post id
     * @var String $_meta queried meta
     * @var String $_type specific type
     */

    private $_args = [];
    private $_id = null;
    private $_meta = "";
    private $_type = "post";

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
    /********** ID **********/
    /**********/

    /*
     * @param Int $id post id
     */

    public function setId(int $id)
    {
        $this->_id = $id;
    }

    /**********/
    /********** ID TO CURRENT ID **********/
    /**********/

    public function setIdToCurrentId()
    {
        global $post;
        if (!empty($post->ID)) {
            $this->setId($post->ID);
        }
    }

    /**********/
    /********** META **********/
    /**********/

    /*
     * @param String $meta queried meta
     */

    public function setMeta(string $meta)
    {
        $this->_meta = $meta;
    }

    /**********/
    /********** TYPE **********/
    /**********/

    /*
     * @param String $type specific type
     */

    public function setType(string $type)
    {
        $this->_type = $type;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** ID **********/
    /**********/

    /*
     * @return Int
     */

    public function getId(): int
    {
        return $this->_id;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** QUERY POST **********/
    /********************************/

    public function queryPost(string $method = null)
    {
        if ($method === "get") {
            return get_posts($this->_args);
        }

        return new WP_Query($this->_args);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET POST **********/
    /******************************/

    /*
     * @return Mixed object || false
     */

    public function getPostById()
    {
        if (empty($this->_id)) {
            return false;
        }

        return get_post($this->_id);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** GET POST ALL ACF FIELDS **********/
    /*********************************************/

    /*
     * @return Mixed array || false 
     */

    public function getPostAllAcfFields(): array
    {
        if (empty($this->_id)) {
            return false;
        }

        $fields = get_fields($this->_id);

        if (is_array($fields)) {
            return $fields;
        }

        return [];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** GET POST ACF FIELD **********/
    /****************************************/

    /*
     * @return Mixed value || false 
     */

    public function getPostAcfField()
    {
        if (empty($this->_meta) || empty($this->_id)) {
            return false;
        }

        return get_field($this->_meta, $this->_id);    
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** GET POST ALL META **********/
    /***************************************/

    /*
     * @return Mixed array || false 
     */

    public function getPostAllMeta(): array
    {
        if (empty($this->_id)) {
            return false;
        }

        return get_post_meta($this->_id);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GET POST META **********/
    /***********************************/

    /*
     * @return Mixed value || false
     */

    public function getPostMeta()
    {
        if (empty($this->_meta) || empty($this->_id)) {
            return false;
        }

        return get_post_meta($this->_meta, $this->_id, true);  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET SLUG **********/
    /******************************/

    /*
     * @return Mixed String || false 
     */

    public function getSlug()
    {
        if (empty($this->_id)) {
            return false;
        }

        $page = get_post($this->_id);
        return $page->post_name;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** GET EXCERPT **********/
    /*********************************/

    /*
     * @return Mixed String || false 
     */

    public function getExcerpt($length = 150)
    {
        if (empty($this->_id)) {
            return false;
        }

        $excerpt = '';
        $post = get_post($this->_id, OBJECT);

        if (!empty($post->post_excerpt)) {

            $excerpt = $post->post_excerpt; 

        } else {
            
            $excerpt = apply_filters('the_content', $post->post_content);
            $excerpt = wp_strip_all_tags(str_replace( ']]>', ']]&gt;', $excerpt));

            if ( strlen($excerpt) > $length) {
                $$excerpt = mb_substr($excerpt, 0, $length, 'UTF-8') . ' [...]';
            }

        }
        
        return $excerpt;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET WPML IDS **********/
    /**********************************/

    /*
     * @param Bool $returnOriginal return original ID if no translation exists
     * @return Mixed Int || false
     */

    public function getWPMLId()
    {
        if (!function_exists('icl_object_id') || empty($this->_id)) {
            return false;
        }

        return icl_object_id($this->_id, $this->type, $returnOriginal);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET WPML IDS **********/
    /**********************************/

    /*
     * @param Bool $returnOriginal return original ID if no translation exists
     * @return Mixed Array || false
     */

    public function getWPMLIds($returnOriginal = true)
    {
        if (!function_exists('icl_object_id') || empty($this->_id)) {
            return false;
        }

        global $sitepress;
        $array = array();
        $defaultLanguage = $sitepress->get_default_language();
        $langs = array_keys(icl_get_languages('skip_missing=0&orderby=KEY&order=DIR&link_empty_to=str'));

        foreach ($langs as $lang) {
            $id = icl_object_id($this->_id, $this->type, $returnOriginal, $lang);
            $array[] = $id;
        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** GET COVER IMAGE ID **********/
    /****************************************/

    /*
     * @return Mixed Int || false
     */

    public function getCoverImgID()
    {
        if (empty($this->_id)) {
            return false;
        }

        if (has_post_thumbnail($this->_id)) {
            return get_post_thumbnail_id($this->_id);
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** UPDATE POST **********/
    /*********************************/

    /*
     * @param Array $data post's data
     * @return Bool
     */

    public function updatePost(&$data)
    {
        if (empty($this->_id) || empty($data) || !is_array($data)) {
            return false;
        }

        $data['ID'] = $this->_id;
        $update = wp_update_post($data);

        return (empty($update));
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** SAVE META ACF **********/
    /***********************************/

    /*
     * @param Array $data meta
     * @return Bool
     */

    public function saveMetaACF($data)
    {
        if (empty($this->_id) || empty($data) || !is_array($data)) {
            return false;
        }

        foreach ($data as $key => $item) {
            
            if (!empty($item['name'])) {
                
                $field = get_field($item['name'], $this->_id);
            
                if ($field != $item[ 'value' ]) {
                    update_field($key, $item[ 'value' ], $this->_id);
                }
                
            }

        }

        return true;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** CHECK IF POST EXISTS **********/
    /******************************************/

    /*
     * @return Bool
     */

    public function checkIfPostExists()
    {
        if (empty($this->_id)) {
            return false;
        }

        $post = get_post($this->_id, OBJECT);
        return (empty($post));
    }

}