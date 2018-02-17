<?php
/**
 * WP System - ACFFieldsHelper - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Helpers;

use Roots\Sage\Container;

/***************************************/
/********** ACF FIELDS HELPER **********/
/***************************************/

final class ACFOptionsHelper
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** INIT ACF OPTIONS **********/
    /**************************************/

    /**
     * @param Array $customSubPages custom sub pages for back office
     * @return Bool
     */

    public static function initACFOptions(array $customSubPages = [])
    {
        try {
            self::_saveLoadSettingsInJson();
            return self::_generateACFPages($customSubPages);
        } catch(\Exception $e) {
            return false;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************************/
    /********** SAVE / LOAD SETTINGS IN JSON **********/
    /**************************************************/

    private static function _saveLoadSettingsInJson()
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

    /****************************************/
    /********** GENERATE ACF PAGES **********/
    /****************************************/

    /**
     * @param Array $customSubPages custom sub pages for back office
     * @return Bool
     */

    private static function _generateACFPages(array $customSubPages = [])
    {
        if (self::_createGeneralOptionsPage()) {
            return self::_generateSettingsPage($customSubPages);
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** CREATE GENERAL OPTIONS PAGE **********/
    /*************************************************/

    /**
     * @return Bool
     */

    private static function _createGeneralOptionsPage()
    {
        $pages = acf_add_options_page(array(
            'page_title' 	=> 'General Settings',
            'menu_title'	=> 'Settings',
            'menu_slug' 	=> 'theme-general-settings',
            'capability'	=> 'manage_options',
            'redirect'		=> false
        ));

        return (is_array($pages) && count($pages) > 0);
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /********************************************/
    /********** GENERATE SETTINGS PAGE **********/
    /********************************************/

    /**
     * @param Array $customSubPages custom sub pages for back office
     * @return Bool
     */

    private static function _generateSettingsPage(array $customSubPages = [])
    {
        if (!function_exists('acf_add_options_page')) {
            return false;
        }

        $subPages = [];
        $defaultSubpages = array(
                        0 => array(
                            'page_title' 	=> 		'Visual Settings',
                            'menu_title'	=> 		'Visual Settings',
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
                            'page_title' 	=> 		'APIs',
                            'menu_title'	=> 		'APIs',
                            'parent_slug'	=> 		'theme-general-settings',
                            'capability'	=> 		'manage_options'
                        ),
                        8 => array(
                            'page_title' 	=> 		'User Roles',
                            'menu_title'	=> 		'User Roles',
                            'parent_slug'	=> 		'theme-general-settings',
                            'capability'	=> 		'manage_options'
                        ) 
                    );

        if (!empty($customSubPages) && !is_array($customSubPages) && count(array_filter($array)) > 0) {
            $subPages = $customSubPages;
        } else {
            $subPages = $defaultSubpages;
        }

        self::_createSubOptionsPages($subPages);
        return true;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** CREATE SUB OPTIONS PAGE **********/
    /*********************************************/

    /**
     * @param Array $pages sub pages to create
     * @return Bool
     */

    private static function _createSubOptionsPages(array $pages): bool
    {
        if (empty($pages) || !is_array($pages)) {
            return false;
        }

        foreach ($pages as $page) {
            acf_add_options_sub_page(array(
                'page_title'	=> 		$page['page_title'],
                'menu_title'	=> 		$page['menu_title'],
                'parent_slug'	=> 		$page['parent_slug'],
                'capability'	=> 		$page['capability']
            ));
        }

        return true;
    }
}