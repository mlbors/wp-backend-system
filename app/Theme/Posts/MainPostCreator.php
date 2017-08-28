<?php
/**
 * WP Backend System - Main Post Creator
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Posts;

/***************************************/
/********** MAIN POST CREATOR **********/
/***************************************/

class MainPostCreator implements PostCreator
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Array $_args CPT's args
     * @var String $_formatedName CPT's formated name
     */

    private $_args;
    private $_formatedName;

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
     * @param Array $args CPT's args
     */

    public function setArgs(array $args)
    {
        $this->_args = $args;
    }

    /**********/
    /********** FORMATED NAME **********/
    /**********/

    /*
     * @param String $formatedName CPT's formated name
     */

    public function setFormatedName(string $formatedName)
    {
        $this->_formatedName = $formatedName;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /********************************************/
    /********** PARSE CUSTOM POST TYPE **********/
    /********************************************/

    private function _parseCPT()
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

            if ($param === 'options_page' && $value === 'acf-options-cpt') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields[0]) && is_array($fields[0])) {

                    $repeater = get_field($fields[0]['name'], 'option');

                    if (have_rows($fields[0]['name'], 'option')) {

                        while (have_rows($fields[0]['name'], 'option')) {
                            the_row();
                            
                            foreach ($fields[0]['sub_fields'] as $field) {

                                $name = $field['name'];
                                $value = get_sub_field($field['name'], 'option');
                                $replacedName = str_replace('option_custom_post_types_', '', $name);

                                switch ($replacedName) {

                                    case 'formated_name':
                                        $this->setFormatedName($value);
                                        break;

                                    case 'labels':

                                        $labels = [];

                                        foreach($value[0] as $l => $label) {
                                            $index = str_replace('option_custom_post_types_labels_', '', $l);
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
                            $this->registerPostType();

                        }

                    }

                }

            }

        }

    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*******************************************/
    /********** SET CUSTOM POST TYPES **********/
    /*******************************************/

    public function setCPT()
    {
        $this->_parseCPT();
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /****************************************/
    /********** REGISTER POST TYPE **********/
    /****************************************/

    /*
     * @return Bool
     */

    public function registerPostType()
    {
        if (empty($this->_formatedName) || empty($this->_args) || !is_array($this->_args)) {
            return false;
        }

        $name = $this->_formatedName;
        $args = $this->_args;

        add_action('init', function() use($name, $args) { 
            $register = register_post_type($name, $args);
            if (is_wp_error($register)) {
                throw new \Exception('CPT ERROR: ' . $register->get_error_messages());
            }
        });
    }

}