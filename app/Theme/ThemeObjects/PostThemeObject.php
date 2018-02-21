<?php
/**
 * WP System - PostThemeObject - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IPageBuilder as IPageBuilder;
use App\Theme\Interfaces\IPageBuilderFactory as IPageBuilderFactory;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;

/***************************************/
/********** POST THEME OBJECT **********/
/***************************************/

class PostThemeObject extends AbstractThemeObject
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IPageBuilder $_pageBuilder page builder object
     * @var IPageBuilderFactory $_pageBuilderFactory object that creates page builders
     */

    protected $_pageBuilder;
    protected $_pageBuilderFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     */

    public function __construct(IEntity $entity, IPageBuilderFactory $pageBuilderFactory)
    {
        parent::__construct($entity);
        $this->_setPostValues($pageBuilderFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** SET POST VALUES **********/
    /*************************************/

    /**
     * @param IPageBuilderFactory $pageBuilderFactory object that creates page builders
     */

    protected function _setPostValues(IPageBuilderFactory $pageBuilderFactory)
    {   
        $this->_setPageBuilderFactory($pageBuilderFactory);
        $this->_instantiatePageBuilder();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** SET PAGE BUILDER FACTORY **********/
    /**********************************************/

    /**
     * @param IPageBuilderFactory $pageBuilderFactory object that creates page builders
     */

    protected function _setPageBuilderFactory(IPageBuilderFactory $pageBuilderFactory)
    {   
        $this->_pageBuilderFactory = $pageBuilderFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** SET PAGE BUILDER **********/
    /**************************************/

    /**
     * @param IPageBuilder $pageBuilder page builder object
     */

    protected function _setPageBuilder(IPageBuilder $pageBuilder)
    {   
        $this->_pageBuilder = $pageBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** GET PAGE BUILDER FACTORY **********/
    /**********************************************/

    /**
     * @return IPageBuilderFactory
     */

    public function getPageBuilderFactory(): IPageBuilderFactory
    {   
        return $this->_pageBuilderFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET PAGE BUILDER **********/
    /**************************************/

    /**
     * @return IPageBuilder
     */

    public function getPageBuilder(): IPageBuilder
    {   
        return $this->_pageBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** INSTANTIATE PAGE BUILDER **********/
    /*************************************************/

    protected function _instantiatePageBuilder()
    {
        $this->_setPageBuilder($this->_pageBuilderFactory->create());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** GET ALL ACF FIELDS **********/
    /****************************************/

    /**
     * @return Mixed array || false 
     */

    public function getAllAcfFields(): array
    {
        if (empty((int)$this->_entity->ID)) {
            return false;
        }

        $fields = get_fields($this->_entity->ID);

        if (is_array($fields)) {
            return $fields;
        }

        return [];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GET ACF FIELD **********/
    /***********************************/

    /**
     * @param String $field trageted field
     * @return Mixed value || false 
     */

    public function getAcfField(string $field)
    {
        if (empty($field) || empty((int)$this->_entity->ID)) {
            return false;
        }

        return get_field($field, $this->_entity->ID);    
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET ALL META **********/
    /**********************************/

    /**
     * @return Mixed array || false 
     */

    public function getAllMeta(): array
    {
        if (empty((int)$this->_entity->ID)) {
            return false;
        }

        return get_post_meta($this->_entity->ID);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET META **********/
    /******************************/

    /**
     * @param String $field trageted field
     * @return Mixed value || false
     */

    public function getMeta(string $field)
    {
        if (empty($field) || empty((int)$this->_entity->ID)) {
            return false;
        }

        return get_post_meta($field, $this->_entity->ID, true);  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET SLUG **********/
    /******************************/

    /**
     * @return Mixed String || false 
     */

    public function getSlug()
    {
        if (empty((int)$this->_entity->ID)) {
            return false;
        }

        return $this->_entity->post_name;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** GET EXCERPT **********/
    /*********************************/

    /**
     * @param Int $length excerpt length
     * @return Mixed String || false 
     */

    public function getExcerpt(int $length = 150)
    {
        if (empty((int)$this->_entity->ID)) {
            return false;
        }

        if (!empty($this->_entity->post_excerpt)) {
            return $excerpt = $post->post_excerpt; 
        }

        $excerpt = '';
        $excerpt = apply_filters('the_content', $this->_entity->post_content);
        $excerpt = wp_strip_all_tags(str_replace( ']]>', ']]&gt;', $excerpt));

        if (strlen($excerpt) > $length) {
            $$excerpt = mb_substr($excerpt, 0, $length, 'UTF-8') . ' [...]';
        }

        return $excerpt;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET WPML IDS **********/
    /**********************************/

    /**
     * @param Bool $returnOriginal return original ID if no translation exists
     * @return Mixed Int || false
     */

    public function getWPMLId()
    {
        if (!function_exists('icl_object_id') || empty((int)$this->_entity->ID)) {
            return false;
        }

        return icl_object_id((int)$this->_entity->ID, $this->_entity->post_type, $returnOriginal);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET WPML IDS **********/
    /**********************************/

    /**
     * @param Bool $returnOriginal return original ID if no translation exists
     * @return Mixed Array || false
     */

    public function getWPMLIds($returnOriginal = true)
    {
        if (!function_exists('icl_object_id') || empty((int)$this->_entity->ID)) {
            return false;
        }

        global $sitepress;
        $array = array();
        $defaultLanguage = $sitepress->get_default_language();
        $langs = array_keys(icl_get_languages('skip_missing=0&orderby=KEY&order=DIR&link_empty_to=str'));

        foreach ($langs as $lang) {
            $id = icl_object_id((int)$this->_entity->ID, $this->_entity->post_type, $returnOriginal, $lang);
            $array[] = $id;
        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** GET COVER IMAGE ID **********/
    /****************************************/

    /**
     * @return Mixed Int || false
     */

    public function getCoverImgID()
    {
        if (empty((int)$this->_entity->ID)) {
            return false;
        }

        if (has_post_thumbnail((int)$this->_entity->ID)) {
            return get_post_thumbnail_id((int)$this->_entity->ID);
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** GET POST TERMS **********/
    /************************************/

    /**
     * @param String $taxonomy targeted taxonomy
     * @param String $kind kind of return value
     * @param String $seperator used when $kind is String
     * @return Mixed String || Array || false
     */

    public function getPostTerms(string $taxonomy, string $kind = 'OBJ', string $sepeartor = ',')
    {
        if (empty((int)$this->_entity->ID) || empty($taxonomy)) {
            return false;
        }

        $terms = wp_get_post_terms($this->_entity->ID, $taxonomy);

        if (empty($terms) || is_wp_error($terms)) {
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

                foreach($terms as $term) {

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

    /**********************************************/
    /********** GET PAGE BUILDER CONTENT **********/
    /**********************************************/

    /**
     * @return Mixed String || False
     */

    public function getPageBuilderContent()
    {
        if (!$this->getAcfField('page_builder_enable')) {
            return false;
        }

        $rows = $this->getAcfField('page_builder_rows');

        if (!ArraysHelper::checkArray($rows)) {
            return false;
        }

        $this->_pageBuilder->setRows($rows);
        return $this->_pageBuilder->build();
    }
}