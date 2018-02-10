<?php
/**
 * WP System - BackViewController - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ViewControllers;

use App\Theme\Interfaces\IViewController as IViewController;
use App\Theme\Helpers\TransientsHelper as TransientsHelper;

/******************************************/
/********** BACK VIEW CONTROLLER **********/
/******************************************/

class BackViewController implements IViewController
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************************/
    /********** DISPLAY TRANSIENTS CACHE RESET VIEW **********/
    /*********************************************************/

    protected function _displayTransientsCacheResetView()
    {
        if (is_admin()) {
            add_action('admin_menu', function() {
                add_menu_page('Cache', 'Cache', 'manage_options', 'cache', function() {

                    if (!current_user_can('manage_options'))  {
                        wp_die(__( 'You do not have sufficient pilchards to access this page.'));
                    }
                    
                    if (isset($_POST['clear_cache']) && check_admin_referer('clear_cache_clicked')) {
                        $clearCache = TransientsHelper::clearTransients();
                        if ($clearCache) {
                            echo '<p>Cache cleared!</p>';
                        } else {
                            echo '<p>There was a problem during the process. Please retry!</p>';
                        }
                    }

                    if (isset($_POST['destroy_cache']) && check_admin_referer('destroy_cache_clicked')) {
                        $clearCache = TransientsHelper::hardReset();
                        if ($clearCache) {
                            echo '<p>Hard reset made!</p>';
                        } else {
                            echo '<p>There was a problem during the process. Please retry!</p>';
                        }
                    }
                    
                    echo '<div class="wrap">';
                        echo '<h2>Cache</h2>';
                        echo '<h3>Clear cache</h3>';
                        echo '<form action="admin.php?page=cache" method="post">';
                            wp_nonce_field('clear_cache_clicked');
                            echo '<input type="hidden" value="true" name="clear_cache" id="clear_cache" />';
                                submit_button('Clear cache');
                            echo '</form>';
                        echo '</form>';
                        echo '<hr />';
                        echo '<h3>Hard reset</h3>';
                        echo '<form action="admin.php?page=cache" method="post">';
                            wp_nonce_field('destroy_cache_clicked');
                            echo '<input type="hidden" value="true" name="destroy_cache" id="destroy_cache" />';
                                submit_button('Hard reset');
                            echo '</form>';
                        echo '</form>';
                    echo '</div>';

                }, 'dashicons-image-rotate');
            });
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************************/
    /********** DISPLAY USER ROLES PURGE VIEW **********/
    /***************************************************/

    protected function _displayUserRolesPurgeView()
    {
        add_action('admin_menu', function() {
            add_submenu_page('theme-general-settings', 'Purge User Roles', 'Purge User Roles', 'manage_options', 'purge-user-roles', function() {

                if (!current_user_can('manage_options'))  {
                    wp_die(__('You do not have sufficient pilchards to access this page.'));
                }

                if (isset($_POST['purge_user_roles' ]) && check_admin_referer('purge_user_roles_clicked')) {

                    global $wp_roles;
                    $roles = $wp_roles->get_names();
                    
                    $result = count_users();
                    $usedRoles = [];

                    if (!empty($result) && is_array($result)) {
                        foreach ($result['avail_roles'] as $role => $count) {
                            if ($count > 1) {
                                array_push($usedRoles, $role);
                            }
                        }
                    }
                    
                    if (!empty($roles)) {
                        foreach ($roles as $r => $role) {
                            if ($r !== 'administrator' && $r !== 'editor' && $r !== 'author' && $r !== 'contributor' && $r !== 'subscriber' && !in_array($r, $usedRoles)) {
                                echo '<p><small>Role ' . $r . ' was deleted!</small></p>';
                                remove_role($r); 
                            } 
                        }
                    }

                    echo '<p><strong>User roles purged!</strong></p>';
                }
                
                echo '<div class="wrap">';
                    echo '<h2>Purge User Roles</h2>';
                    echo '<form action="admin.php?page=purge-user-roles" method="post">';
                        wp_nonce_field('purge_user_roles_clicked');
                        echo '<input type="hidden" value="true" name="purge_user_roles" id="purge_user_roles" />';
                            submit_button('Purge unused user roles');
                        echo '</form>';
                    echo '</form>';
                echo '</div>';

            });
        }, 99);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    public function display()
    {
        $this->_displayTransientsCacheResetView();
        $this->_displayUserRolesPurgeView();
    }
}