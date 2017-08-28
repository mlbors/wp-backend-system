<?php
/**
 * WP Backend System - Settings Handler
 *
 * @since       04.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Settings;

use \App\Theme\Posts\PostGetter as PostGetter;

/**************************************/
/********** SETTINGS HANDLER **********/
/**************************************/

class SettingsHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Array $_settings theme settings
     */

    private $_settings = [];

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
    /********** SET VALUES **********/
    /**********/

    private function _setValues()
    {
    }

    /**********/
    /********** SETTINGS **********/
    /**********/

    /*
     * @param Array $settings array of settings
     */

    private function _setSettings(array $settings)
    {
        return $this->_settings = $settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** SETTINGS **********/
    /**********/

    /*
     * @return Array
     */

    public function getSettings(): array
    {
        return $this->_settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************************/
    /********** SAVE / LOAD SETTINGS IN JSON **********/
    /**************************************************/

    private function _saveLoadSettingsInJson()
    {
        add_filter('acf/settings/save_json', function($path) {
            $path = get_stylesheet_directory() . '/acf-json';
            return $path;
        });

        add_filter('acf/settings/load_json', function($paths) {
            unset($paths[0]);
            $paths[] = get_stylesheet_directory() . '/acf-json';
            return $paths;
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** RETRIEVE SETTINGS **********/
    /***************************************/

    private function _retrieveSettings()
    {
        $settings = [];

        $groups = get_posts([
                    'posts_per_page'   => -1,
                    'post_type'        => 'acf-field-group',
                  ]);

        if (empty($groups) || !is_array($groups) || !$groups) {
            return false;
        }

        foreach ($groups as $group) {

            $groupInfo = maybe_unserialize($group->post_content)['location'][0][0];
            $param = $groupInfo['param'];
            $value = $groupInfo['value'];

            if ($param === 'options_page' 
                && $value !== 'acf-options-cpt' 
                && $value !== 'acf-options-taxonomies' 
                && $value !== 'acf-options-shortcodes' 
                && $value !== 'acf-options-user-roles' 
                && $value !== 'acf-options-redirections' 
                && $value !== 'acf-options-options'
                && $value !== 'acf-options-widgets') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields) && is_array($fields)) {
                    foreach ($fields as $field) {
                        $settings[$field['name']] = get_field($field['name'], 'option');
                    }
                }

            }

        }

        $this->_setSettings($settings);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** CREATE GENERAL OPTIONS PAGE **********/
    /*************************************************/

    private function _createGeneralOptionsPage()
    {
        acf_add_options_page(array(
            'page_title' 	=> 'General Settings',
            'menu_title'	=> 'Settings',
            'menu_slug' 	=> 'theme-general-settings',
            'capability'	=> 'manage_options',
            'redirect'		=> false
        ));
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** CREATE SUB OPTIONS PAGE **********/
    /*********************************************/

    /*
     * @param Array $pages sub pages to create
     */

    private function _createSubOptionsPages(array $pages)
    {
        if (!empty($pages) && is_array($pages)) {

            foreach ($pages as $page) {

                acf_add_options_sub_page(array(
                    'page_title'	=> 		$page['page_title'],
                    'menu_title'	=> 		$page['menu_title'],
                    'parent_slug'	=> 		$page['parent_slug'],
                    'capability'	=> 		$page['capability']
                ));

            }

        }
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /********************************************/
    /********** GENERATE SETTINGS PAGE **********/
    /********************************************/

    public function generateSettingsPage()
    {
        if (function_exists('acf_add_options_page')) {

            $subPages = array(
                            0 => array(
                                'page_title' 	=> 		'Networks Settings',
                                'menu_title'	=> 		'Networks',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ),
                            1 => array(
                                'page_title' 	=> 		'CPT',
                                'menu_title'	=> 		'CPT',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ),
                            2 => array(
                                'page_title' 	=> 		'Taxonomies',
                                'menu_title'	=> 		'Taxonomies',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ),
                            3 => array(
                                'page_title' 	=> 		'Shortcodes',
                                'menu_title'	=> 		'Shortcodes',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ),
                            4 => array(
                                'page_title' 	=> 		'Redirections',
                                'menu_title'	=> 		'Redirections',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ),
                            5 => array(
                                'page_title' 	=> 		'Options',
                                'menu_title'	=> 		'Options',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ),
                            6 => array(
                                'page_title' 	=> 		'Widgets',
                                'menu_title'	=> 		'Widgets',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ),
                            7 => array(
                                'page_title' 	=> 		'User Roles',
                                'menu_title'	=> 		'User Roles',
                                'parent_slug'	=> 		'theme-general-settings',
                                'capability'	=> 		'manage_options'
                            ) 
                        );

            $this->_createGeneralOptionsPage();
            $this->_createSubOptionsPages($subPages);
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        try {
            $this->_retrieveSettings();
            $this->_saveLoadSettingsInJson();
        } catch (\Exception $e) {
            return false;
        }
    }
    
}