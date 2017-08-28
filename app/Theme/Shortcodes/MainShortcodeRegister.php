<?php
/**
 * WP Backend System - Main Shortcode Register
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Shortcodes;

use \App;

use \App\Theme\Posts\PostGetter as PostGetter;
use \App\Theme\Taxonomies\TaxonomyGetter as TaxonomyGetter;
use \App\Theme\Transients\TransientOperator as TransientOperator;

/*********************************************/
/********** MAIN SHORTCODE REGISTER **********/
/*********************************************/

class MainShortcodeRegister implements ShortcodeRegister
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var PostGetter $_postGetter object that gets posts
     * @var TaxonomyGetter $_taxonomyGetter object that gets taxonomies
     * @var TransientOperator $_transientOperator object that handles transients
     * @var Array $_shortcodes array of shortcodes
     */

    private $_postGetter;
    private $_taxonomyGetter;
    private $_transientOperator;
    private $_shortcodes = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param PostGetter $postGetter object that gets posts
     * @param TaxonomyGetter $taxonomyGetter object that gets taxonomies
     * @param TransientOperator $transientOperator object that handles transients
     */

    public function __construct(PostGetter $postGetter, TaxonomyGetter $taxonomyGetter, TransientOperator $transientOperator)
    {
        $this->_setValues($postGetter, $taxonomyGetter, $transientOperator);
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
     * @param PostGetter $postGetter object that gets posts
     * @param TaxonomyGetter $taxonomyGetter object that gets taxonomies
     * @param TransientOperator $transientOperator object that handles transients
     */

    private function _setValues(PostGetter $postGetter, TaxonomyGetter $taxonomyGetter, TransientOperator $transientOperator)
    {
        $this->_setPostGetter($postGetter);
        $this->_setTaxonomyGetter($taxonomyGetter);
        $this->_setTransientOperator($transientOperator);
    }

    /**********/
    /********** POST GETTER **********/
    /**********/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    private function _setPostGetter(PostGetter $postGetter)
    {
        $this->_postGetter = $postGetter;
    }

    /**********/
    /********** TAXONOMY GETTER **********/
    /**********/

    /*
     * @param TaxonomyGetter $taxonomyGetter object that gets taxonomies
     */

    private function _setTaxonomyGetter(TaxonomyGetter $taxonomyGetter)
    {
        $this->_taxonomyGetter = $taxonomyGetter;
    }

    /**********/
    /********** TRANSIENT OPERATOR **********/
    /**********/

    /*
     * @param TransientOperator $transientOperator object that handles transients
     */

    private function _setTransientOperator(TransientOperator $transientOperator)
    {
        $this->_transientOperator = $transientOperator;
    }

    /**********/
    /********** SHORTCODES **********/
    /**********/

    /*
     * @param Array $shortcodes array of shortcodes
     */

    private function _setShortcodes(array $shortcodes)
    {
        $this->_shortcodes = $shortcodes;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** PARSE FIELDS **********/
    /**********************************/

    /*
     * @param Array $fields shortcode fields
     * @return Array
     */

    private function _parseFields($fields): array
    {
        $array = [];

        foreach ($fields as $f => $field) {
            $fieldObject = get_field_object($f);
            $array[$fieldObject['name']] = $field;
        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************************/
    /********** PREPARE POSTS LIST SHORTCODE **********/
    /**************************************************/

    /*
     * @param Array $fields shortcode fields
     * @return Array
     */

    private function _preparePostsListShortcode($fields): array
    {
        $array = [];
        $settings = $this->_parseFields($fields);

        $hasTaxQuery = false;
        $hasMetaQuery = false;
        $hasTransient = false;

        foreach ($settings as $s => $setting) {

            $fieldName = str_replace('custom_shortcodes_post_lists_', '', $s);

            switch ($fieldName) {

                case 'view_other':
                case 'view':
                case 'includes':
                case 'use_transient':
                case 'transient_time':
                    if (!empty($setting)) {
                        $array[$fieldName] = $setting;
                    }
                    break;

                case 'tax_query_bool':
                    if (!empty($setting)) {
                        $hasTaxQuery = true;
                    }
                    break;

                case 'tax_query_param':
                    if (!empty($setting) && $hasTaxQuery) {
                        
                        $array['args']['tax_query'] = [];
                        $i = 0;

                        foreach ($setting as $query) {

                            $array['args']['tax_query'][$i] = [];

                            $keys = array_keys($query);
                            $terms = explode(",", $query[$keys[2]]);

                            $array['args']['tax_query'][$i]['taxonomy'] = (string) $query[$keys[0]];
                            $array['args']['tax_query'][$i]['field'] = (string) $query[$keys[1]];
                            $array['args']['tax_query'][$i]['terms'] = $terms;
                            $array['args']['tax_query'][$i]['operator'] = (string) $query[$keys[3]];

                            $i++;

                        }

                    }
                    break;

                case 'tax_query_relation':
                    if (!is_null($setting) && $hasTaxQuery && count($array['args']['tax_query']) > 1) {
                        $array['args']['tax_query']['relation'] = $setting;
                    }
                    break;

                case 'meta_query_bool':
                    if (!empty($setting)) {
                        $hasMetaQuery = true;
                    }
                    break;

                case 'meta_query_param':
                    if (!empty($setting) && $hasMetaQuery) {
                        
                        $array['args']['meta_query'] = [];
                        $i = 0;
                        
                        foreach ($setting as $query) {

                            $array['args']['meta_query'][$i] = [];

                            $keys = array_keys($query);
                            $value = explode(",", $query[$keys[1]]);

                            if ($query[$keys[2]] !== 'IN' && $query[$keys[2]] !== 'NOT IN' && $query[$keys[2]] !== 'BETWEEN' && $query[$keys[2]] !== 'NOT BETWEEN') {
                                $value = $value[0];
                            }

                            $array['args']['meta_query'][$i]['key'] = (string) $query[$keys[0]];
                            $array['args']['meta_query'][$i]['value'] = $value;
                            $array['args']['meta_query'][$i]['compare'] = (string) $query[$keys[2]];
                            $array['args']['meta_query'][$i]['type'] = (string) $query[$keys[3]];

                            $i++;

                        }

                    }
                    break;

                case 'meta_query_relation':
                    if (!is_null($setting) && $hasMetaQuery && count($array['args']['meta_query']) > 1) {
                        $array['args']['meta_query']['relation'] = $setting;
                    }
                    break;

                case 'limit':
                    if (empty($setting)) {
                        $array['args']['limit'] = -1;
                    } else {
                        $array['args']['limit'] = $setting;
                    }
                    break;

                case 'post_status';
                    if (empty($setting)) {
                        $array['args']['post_status'] = 'publish';
                    } else {
                        if (count($setting) > 1) {
                            $array['args']['post_status'] = $setting; 
                        } else {
                            $array['args']['post_status'] = (string) $setting[0]; 
                        }
                    }
                    break;

                default:
                    if (!empty($setting)) {
                        $array['args'][$fieldName] = $setting;
                    }
                    break;

            }

        }
        return $array;  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************************/
    /********** PREPARE SINGLE POST SHORTCODE **********/
    /***************************************************/

    /*
     * @param Array $fields shortcode fields
     * @return Array
     */

    private function _prepareSinglePostShortcode($fields): array
    {
        $array = [];
        $settings = $this->_parseFields($fields);

        foreach ($settings as $s => $setting) {

            $fieldName = str_replace('custom_shortcodes_display_post_', '', $s);

            switch ($fieldName) {

                case 'post':
                    $array['post_id'] = $setting;
                    break;

                default:
                    if (!empty($setting)) {
                        $array[$fieldName] = $setting;
                    }
                    break;

            }

        }

        return $array;  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** PREPARE TEXT SHORTCODE **********/
    /********************************************/

    /*
     * @param Array $fields shortcode fields
     * @return Array
     */

    private function _prepareTextShortcode($fields): array
    {
        $array = [];
        $settings = $this->_parseFields($fields);

        foreach ($settings as $s => $setting) {

            $fieldName = str_replace('custom_shortcodes_display_text_', '', $s);

            if (!empty($setting)) {
                $array[$fieldName] = $setting;
            }

        }

        return $array;
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** PREPARE VIEW SHORTCODE **********/
    /********************************************/

    /*
     * @param Array $fields shortcode fields
     * @return Array
     */

    private function _prepareViewShortcode($fields): array
    {
        $array = [];
        $array['view'] = 'other';

        $settings = $this->_parseFields($fields);

        foreach ($settings as $s => $setting) {

            $fieldName = str_replace('custom_shortcodes_display_view_', '', $s);

            if (!empty($setting)) {
                $array[$fieldName] = $setting;
            }

        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** PREPARE IMAGE SHORTCODE **********/
    /*********************************************/

    /*
     * @param Array $fields shortcode fields
     * @return Array
     */

    private function _prepareImageShortcode($fields): array
    {
        $array = [];
        $settings = $this->_parseFields($fields);

        foreach ($settings as $s => $setting) {

            $fieldName = str_replace('custom_shortcodes_display_image_', '', $s);

            if (!empty($setting)) {
                $array[$fieldName] = $setting;
            }

        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** PREPARE GALLERY SHORTCODE **********/
    /***********************************************/

    /*
     * @param Array $fields shortcode fields
     * @return Array
     */

     private function _prepareGalleryShortcode($fields): array
     {
         $array = [];
         $settings = $this->_parseFields($fields);
 
         foreach ($settings as $s => $setting) {
 
             $fieldName = str_replace('custom_shortcodes_display_gallery_', '', $s);
 
             if (!empty($setting)) {
                 $array[$fieldName] = $setting;
             }
 
         }
 
         return $array;
     }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** PREPARE SHORTCODE **********/
    /***************************************/

    /*
     * @param String $type type of shortcode
     * @param Array $fields shortcode fields
     * @return Array
     */

    private function _prepareShortcode(string $type, array $fields): array
    {
        $result = [];
        $result['name'] = $fields[array_keys($fields)[0]];
        $result['type'] = $fields[array_keys($fields)[1]];

        switch ($type) {
            case 'posts':
                $result['shortcode'] = $this->_preparePostsListShortcode($fields[array_keys($fields)[2]]);
                break;

            case 'post':
                $result['shortcode']  = $this->_prepareSinglePostShortcode($fields[array_keys($fields)[3]]);
                break;

            case 'text':
                $result['shortcode'] = $this->_prepareTextShortcode($fields[array_keys($fields)[4]]);
                break;

            case 'view':
                $result['shortcode'] = $this->_prepareViewShortcode($fields[array_keys($fields)[5]]);
                break;

            case 'image':
                $result['shortcode'] = $this->_prepareImageShortcode($fields[array_keys($fields)[6]]);
                break;

            case 'gallery':
                $result['shortcode'] = $this->_prepareGalleryShortcode($fields[array_keys($fields)[7]]);
                break;
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /**************************************/
    /********** PARSE SHORTCODES **********/
    /**************************************/

    /*
     * @return Mixed Array || false
     */

    private function _parseShortcodes()
    {
        $shortcodes = [];

        $this->_postGetter->setArgs([
                                'posts_per_page'   => -1,
                                'post_type'        => 'acf-field-group',
                            ]);
        $groups = $this->_postGetter->queryPost('get');

        if (empty($groups)|| !is_array($groups) || !$groups) {
            return false;
        }

        foreach ($groups as $group) {

            $groupInfo = maybe_unserialize($group->post_content)['location'][0][0];
            $param = $groupInfo['param'];
            $value = $groupInfo['value'];

            if ($param === 'options_page' && $value === 'acf-options-shortcodes') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields[0]) && is_array($fields[0])) {

                    $repeater = get_field($fields[0]['name'], 'option');

                    if (have_rows($fields[0]['name'], 'option')) {

                        while (have_rows($fields[0]['name'], 'option')) {
                            the_row();
                            $type = get_sub_field('custom_shortcodes_type', 'option');
                            array_push($shortcodes, $this->_prepareShortcode($type, get_row()));
                        }

                    }

                }

            }

        }

        $this->_setShortcodes($shortcodes);
        return $shortcodes;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** RENDER SHORTCODE **********/
    /**************************************/

    /*
     * @param Array $data shortcode's data
     * @return Mixed
     */

    private function _renderShortcode($data)
    {
        ob_start();
        
        $view = $data['shortcode']['view'];

        if ($view === 'other') {
            $view = $data['shortcode']['view_other'];
        }

        $template = 'shortcodes/' . $view;
        echo \App\template($template, ['data' => $data['shortcode']]);
        return ob_get_clean();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** EXECUTE POSTS QUERY **********/
    /*****************************************/

    /*
     * @param Array $data shortcode's data
     * @return Array
     */

    private function _excutePostsQuery(&$data): array
    {
        try {
            
            $this->_postGetter->setArgs($data['shortcode']['args']);
            $data['shortcode']['results'] = $this->_postGetter->queryPost();
            return $data;

        } catch (\Exception $e) {
            return $data;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** EXECUTE SINGLE POST QUERY **********/
    /***********************************************/

    /*
     * @param Array $data shortcode's data
     * @return Array
     */

    private function _executeSinglePostQuery(&$data): array
    {
        try {

            $this->_postGetter->setId($data['shortcode']['post_id']);
            $data['shortcode']['post'] = $this->_postGetter->getPostById();
            if (in_array('meta', $data['shortcode']['includes'])) {
                $data['shortcode']['acf_fields'] = $this->_postGetter->getPostAllAcfFields();
                $data['shortcode']['meta'] = $this->_postGetter->getPostAllMeta();
            }
            return $data;

        } catch (\Exception $e) {
            return $data;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** EXECUTE IMAGE QUERY **********/
    /*****************************************/

    /*
     * @param Array $data shortcode's data
     * @return Array
     */

    private function _excecuteImageQuery(&$data): array
    {
        try {

            $data['shortcode']['image_data'] = wp_get_attachment_metadata($data['shortcode']['image'], false);
            $data['shortcode']['image_data']['full_path'] = wp_get_attachment_image_src($data['shortcode']['image'], 'full')[0];
            foreach ($data['shortcode']['image_data']['sizes'] as $s => $sizes) {
                $data['shortcode']['image_data']['sizes'][$s]['full_path'] = wp_get_attachment_image_src($data['shortcode']['image'], $s)[0];
            }
            return $data;
            
        } catch (\Exception $e) {
            return $data;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** EXECUTE GALLERY QUERY **********/
    /*******************************************/

    /*
     * @param Array $data shortcode's data
     * @return Array
     */

    private function _excecuteGalleryQuery(&$data): array
    {
        try {

            foreach ($data['shortcode']['images'] as $i => $image) {
                $data['shortcode']['images_data'][$i] = wp_get_attachment_metadata($image, false);
                $data['shortcode']['images_data'][$i]['full_path'] = wp_get_attachment_image_src($image, 'full')[0];
                foreach ($data['shortcode']['images_data'][$i]['sizes'] as $s => $sizes) {
                    $data['shortcode']['images_data'][$i]['sizes'][$s]['full_path'] = wp_get_attachment_image_src($image, $s)[0];
                }
            }
            return $data;

        } catch (\Exception $e) {
            return $data;
        }
    }
 

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** EXECUTE QUERY **********/
    /***********************************/

    /*
     * @param Array $data shortcode's data
     * @return Array
     */

    private function _executeQuery(&$data): array
    {
        switch ($data['type']) {
            case 'posts':
                $this->_excutePostsQuery($data);
                break;

            case 'post':
                $this->_executeSinglePostQuery($data);
                break;

            case 'image':
                $this->_excecuteImageQuery($data);
                break;

            case 'gallery':
                $this->_excecuteGalleryQuery($data);
                break;
        }
        return $data;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** PREPROCESS SHORTCODE **********/
    /******************************************/

    /*
     * @param Array $data shortcode's data
     */

    private function _preprocesShortcode(&$data)
    {
        $this->_executeQuery($data);
        return $this->_renderShortcode($data);
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /***************************************/
    /********** EXECUTE SHORTCODE **********/
    /***************************************/

    /*
     * @param Array $data shortcode's data
     * @return Mixed
     */

    private function _executeShortcode($data)
    {
        if (!empty($data['shortcode']['use_transient'])) {
            
            $operator = $this->_transientOperator->operate($data['name']);

            if ($operator) {
                return $operator;
            } else {
                $render = $this->_preprocesShortcode($data);
                $this->_transientOperator->initTransient($data['name'], $data['shortcode']['transient_time'], $render);
                return $render;
            }

        } 

        return $this->_preprocesShortcode($data);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** REGISTER **********/
    /******************************/

    /*
     * @param String $name shortcode's name
     * @param Array $data shortcode's data
     */

    public function registerShortcode(string $name, array $data)
    {
        $class = $this;
        add_shortcode($name, function() use ($class, $data) {
            return $class->_executeShortcode($data);
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** LOOP OVER SHORTCODES **********/
    /******************************************/

    private function _loopOverShortcodes()
    {
        if (!empty($this->_shortcodes) && is_array($this->_shortcodes)) {
            foreach ($this->_shortcodes as $shortcode) {
                $this->registerShortcode($shortcode['name'], $shortcode);
            }
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /***************************************/
    /********** SET UP SHORTCODES **********/
    /***************************************/

    public function setUpShortcodes()
    {
        $this->_parseShortcodes();
        $this->_loopOverShortcodes();
    }

}