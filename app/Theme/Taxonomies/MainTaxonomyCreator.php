<?php
/**
 * WP Backend System - Main Taxonomy Creator
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Taxonomies;

/********************************************/
/********** MAIN TAXONOMIE CREATOR **********/
/********************************************/

class MainTaxonomyCreator implements TaxonomyCreator
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Array $_args taxonomy's args
     * @var String $_formatedName taxonomy's formated name
     * @var String $_postType targeted post type
     */

    private $_args;
    private $_formatedName;
    private $_postType;

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
     * @param Array $_args taxonomy's args
     */

    public function setArgs(array $args)
    {
        $this->_args = $args;
    }

    /**********/
    /********** FORMATED NAME **********/
    /**********/

    /*
     * @param String $_formatedName taxonomy's formated name
     */

    public function setFormatedName(string $formatedName)
    {
        $this->_formatedName = $formatedName;
    }

    /**********/
    /********** POST TYPE **********/
    /**********/

    /*
     * @param String $_postType targeted post type
     */

    public function setPostType(string $postType)
    {
        $this->_postType = $postType;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*********************************************/
    /********** PARSE CUSTOM TAXONOMIES **********/
    /*********************************************/

    private function _parseCustomTaxonomies()
    {
        $args = [];

        $groups = get_posts([
                    'posts_per_page'   => -1,
                    'post_type'        => 'acf-field-group',
                  ]);

        if (empty($groups)|| !is_array($groups) || !$groups) {
            return false;
        }

        foreach ($groups as $group) {

            $groupInfo = maybe_unserialize($group->post_content)['location'][0][0];
            $param = $groupInfo['param'];
            $value = $groupInfo['value'];

            if ($param === 'options_page' && $value === 'acf-options-taxonomies') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields[0]) && is_array($fields[0])) {

                    $repeater = get_field($fields[0]['name'], 'option');

                    if (have_rows($fields[0]['name'], 'option')) {

                        while (have_rows($fields[0]['name'], 'option')) {
                            the_row();
                            
                            foreach($fields[0]['sub_fields'] as $field) {

                                $name = $field['name'];
                                $value = get_sub_field($field['name'], 'option');
                                $replacedName = str_replace('option_custom_taxonomies_', '', $name);

                                switch ($replacedName) {

                                    case 'formated_name':
                                        $this->setFormatedName($value);
                                        break;

                                    case 'post_type':
                                        $this->setPostType($value);
                                        break;

                                    case 'labels':

                                        $labels = [];

                                        foreach($value[0] as $l => $label) {
                                            $index = str_replace('option_custom_taxonomies_labels_', '', $l);
                                            if ($label !== '' && !is_null($label)) {
                                                $labels[$index] = $label;
                                            }
                                        }

                                        $args['labels'] = $labels;
                                        break;

                                    default:

                                        if ($value !== '' && !is_null($value)) {
                                            $args[$replacedName] = $value;
                                        }

                                        break;

                                }
                                
                            }

                            $this->setArgs($args);
                            $this->registerTaxonomy();

                        }

                    }

                }

            }

        }

    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*******************************************/
    /********** SET CUSTOM TAXONOMIES **********/
    /*******************************************/

    public function setCustomTaxonomies()
    {
        $this->_parseCustomTaxonomies();
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /***************************************/
    /********** REGISTER TAXONOMY **********/
    /***************************************/

    public function registerTaxonomy()
    {
        $register = register_taxonomy($this->_formatedName, $this->_postType, $this->_args);

        if (is_wp_error($register)) {
            throw new \Exception('TAX ERROR: ' . $register->get_error_messages());
        }
    }

}