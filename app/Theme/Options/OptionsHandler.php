<?php
/**
 * WP Backend System - Options Handler
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Options;

use App\Theme\Posts\PostGetter as PostGetter;

/*************************************/
/********** OPTIONS HANDLER **********/
/*************************************/

class OptionsHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var PostGetter $_postGetter object that gets posts
     * @var Array $_redirections array of options to manage
     */

    private $_postGetter;
    private $_options = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    public function __construct(PostGetter $postGetter)
    {
        $this->_setValues($postGetter);
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
     */

    private function _setValues(PostGetter $postGetter)
    {
        $this->_setPostGetter($postGetter);
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
    /********** OPTIONS **********/
    /**********/

    /*
     * @param Array $options array of options to manage
     */

    private function _setOptions(array $options)
    {
        $this->_options = $options;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** OPTIONS **********/
    /**********/

    /*
     * @param Array
     */

    public function getOptions(): array
    {
        return $this->_options;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** PARSE REDIRECTIONS **********/
    /****************************************/

    /*
     * @return Array
     */

    private function _parseOptions()
    {
        $options = [];

        $hideMenusToUsers = false;
        $hideOptionsToUsers = false;
        
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

            if ($param === 'options_page' && $value === 'acf-options-options') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields[0]) && is_array($fields[0])) {

                    foreach ($fields as $f => $field) {

                        $fieldName = str_replace('custom_options_', '', $field['name']);

                        switch ($fieldName) {

                            case 'hide_menus_to_users_bool':
                                $hideMenusToUsers = get_field($field['name'], 'option');
                                break;

                            case 'hide_options_to_users_bool':
                                $hideOptionsToUsers = get_field($field['name'], 'option');
                                break;
                            
                            case 'hide_menus_to_users':
                                if ($hideMenusToUsers) {
                                    $value = get_field($field['name'], 'option');

                                    if (!empty($value)) {
                                        $users = explode(",", $value);
                                        $options[$fieldName]['hide'] = true;
                                        $options[$fieldName]['users'] = $users;
                                    }

                                }
                                break;

                            case 'hide_options_to_users':
                                if ($hideOptionsToUsers) {
                                    $value = get_field($field['name'], 'option');

                                    if (!empty($value)) {
                                        $users = explode(",", $value);
                                        $options[$fieldName]['hide'] = true;
                                        $options[$fieldName]['users'] = $users;
                                    }

                                }
                                break;

                            default:
                                $options[$fieldName] = get_field($field['name'], 'option');
                                break;

                        }
                    }
                }
            }
        }

        $this->_setOptions($options);
        return $options;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** DISABLE COMMENTS **********/
    /**************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _disableComments($option)
    {
        if ($option) {

            add_action('init', function() {
                if (is_admin_bar_showing()) {
                    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
                }
            });

            add_action('admin_init', function() {
                $postTypes = get_post_types();
                foreach ($postTypes as $postType) {
                    if (post_type_supports($postType, 'comments')) {
                        //remove_post_type_support($postType, 'comments');
                        remove_post_type_support($postType, 'trackbacks');
                    }
                }
                remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
                remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
            });

            add_filter('pings_open', function() {
                return false;
            }, 20, 2);

        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** HIDE ADMIN BAR **********/
    /************************************/

    /*
     * @param Mixed $option option settings
     */

     private function _hideAdminBar($option)
     {
         if ($option) {
            add_action('wp', function() {
                if (!is_admin()) {
                    show_admin_bar(false);
                }
            });
         }
     }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** REMOVE OPTIONS ADMIN BAR **********/
    /**********************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _removeOptionsAdminBar($option)
    {
        if ($option && is_admin()) {
            add_action('wp_before_admin_bar_render', function() {
                global $wp_admin_bar;
                $wp_admin_bar->remove_menu('wp-logo');
                $wp_admin_bar->remove_menu('new-content');
                $wp_admin_bar->remove_menu('about');
                $wp_admin_bar->remove_menu('wporg');
                $wp_admin_bar->remove_menu('documentation');
                $wp_admin_bar->remove_menu('support-forums');
                $wp_admin_bar->remove_menu('feedback');
                $wp_admin_bar->remove_menu('new-page');
                $wp_admin_bar->remove_menu('comments');
                $wp_admin_bar->remove_menu('updates');
            });
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** REMOVE DASHBOARD META BOX **********/
    /***********************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _removeDashboardMetaBox($option)
    {
        if ($option && is_admin()) {
            add_action('admin_init', function() {
                remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
                remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
                remove_meta_box('dashboard_primary', 'dashboard', 'normal');
                remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
                remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
                remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
                remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
                remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
                remove_meta_box('dashboard_activity', 'dashboard', 'normal');
            });
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** REMOVE UPDATE NOTIFICATIONS **********/
    /*************************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _removeUpdateNotifications($option) 
    {
        if ($option && is_admin()) {

            add_action('admin_menu', function() {
                global $submenu;
                remove_submenu_page('index.php', 'update-core.php');
            }, 999);

            add_action('admin_head', function() {
                remove_action('admin_notices', 'update_nag', 3);
            }, 1);

            add_action('wp_before_admin_bar_render', function() {
                global $wp_admin_bar;
                $wp_admin_bar->remove_menu('updates');
            });
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** HIDE MENUS TO USERS **********/
    /*****************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _hideMenusToUsers($option)
    {
        if ($option['hide'] && is_admin()) {

            add_action('admin_menu', function() use($option) {

                $user = wp_get_current_user();

                if (in_array($user->user_login, $option['users'])) {

                    global $menu;
                    global $submenu;

                    remove_menu_page('tools.php');
                    remove_menu_page('plugins.php');
                    remove_menu_page('options-general.php');
                    remove_menu_page('edit.php?post_type=acf-field-group');
                    //remove_menu_page('themes.php');

                    unset($submenu['themes.php'][5]);
                    unset($submenu['themes.php'][6]);
                    unset($submenu['themes.php'][12]);
                    unset($submenu['themes.php'][15]);
                    
                    $restricted = array(
                        'toplevel_page_themepunch-google-fonts',
                        'toplevel_page_bwp_capt_general',
                        'toplevel_page_vc-general',
                        'toplevel_page_vc-welcome'
                    );

                    foreach ($menu as $item => $data) { 
                        if (!isset( $data[5])) {
                            continue;
                        } elseif (in_array($data[5], $restricted)) {
                            unset($menu[$item]);
                        }
                    }
                }

            });
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** HIDE OPTIONS TO USERS **********/
    /*******************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _hideOptionsToUsers($option)
    {
        if ($option['hide'] && is_admin()) {

            add_action('admin_init', function() use($option) {

                $user = wp_get_current_user();
                
                if (in_array($user->user_login, $option['users'])) {
                    
                    global $submenu;
                    unset($submenu['theme-general-settings'][2]);
                    unset($submenu['theme-general-settings'][3]);
                    unset($submenu['theme-general-settings'][4]);
                    unset($submenu['theme-general-settings'][5]);
                    unset($submenu['theme-general-settings'][6]);
                    unset($submenu['theme-general-settings'][7]);
                    unset($submenu['theme-general-settings'][8]);
                    unset($submenu['theme-general-settings'][9]);
                    
                }

            });

        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** ADD QUERY ARGS **********/
    /************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _addQueryArgs($option)
    {
        add_filter('query_vars', function($vars) use ($option) {
            $explodedOption = explode(",", $option);
            foreach ($explodedOption as $i => $item) {
                $vars[] = $item;
                return $vars;
            }
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** ADD IMAGE SIZES **********/
    /*************************************/

    /*
     * @param Mixed $option option settings
     */

    private function _addImageSizes($option)
    {
        $prefix = 'custom_options_add_image_sizes_';
        if (is_array($option)) {
            foreach ($option as $i => $item) {
                add_image_size($item[$prefix . 'name'], $item[$prefix . 'width'], $item[$prefix . 'height'], $item[$prefix . 'crop']);
            }
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** ADD MIMES **********/
    /*******************************/

    /*
     * @param Mixed $option option settings
     */

    private function _addMimes($option)
    {
        add_filter('upload_mimes', function($mimes) use ($option) {
            $prefix = 'custom_options_add_mimes_';
            if (is_array($option)) {
                foreach ($option as $i => $item) {
                    $mimes[$item[$prefix . 'extenson']] = $item[$prefix . 'type'];
                }
            }
            return $mimes;
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** APPLY OPTIONS **********/
    /***********************************/

    private function _applyOptions()
    {
        if (!empty($this->_options) && is_array($this->_options)) {
            foreach ($this->_options as $o => $option) {
                $method = '_' . lcfirst(str_replace('_', '', ucwords($o, '_')));
                $this->{$method}($option);
            }
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET UP OPTIONS **********/
    /************************************/

    public function setUpOptions()
    {
        try {
            $this->_parseOptions();
            $this->_applyOptions();
        } catch (\Exception $e) {
            return false;
        }
    }

}