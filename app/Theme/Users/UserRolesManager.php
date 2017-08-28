<?php
/**
 * WP Backend System - User Roles Manager
 *
 * @since       11.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Users;

use WP_User;

/****************************************/
/********** USER ROLES MANAGER **********/
/****************************************/

class UserRolesManager
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var Array $_roles user roles
     */

    private $_roles;

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
    /********** ROLES **********/
    /**********/

    /*
     * @param Array $roles user roles
     */

    private function _setRoles($roles)
    {
        $this->_roles = $roles;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** PARSE USER ROLES **********/
    /**************************************/

    private function _parseUserRoles()
    {
        $array = [];
        
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

            if ($param === 'options_page' && $value === 'acf-options-user-roles') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields[0]) && is_array($fields[0])) {

                    $repeater = get_field($fields[0]['name'], 'option');

                    if (have_rows($fields[0]['name'], 'option')) {

                        while (have_rows($fields[0]['name'], 'option')) {
                            the_row();

                            $role = [];
                            
                            foreach ($fields[0]['sub_fields'] as $field) {

                                $name = $field['name'];
                                $value = get_sub_field($field['name'], 'option');
                                $replacedName = str_replace('custom_user_roles_', '', $name);

                                switch ($replacedName) {

                                    case 'capabilities':

                                        $capabilities = [];
                                        $subFieldObject = get_sub_field_object($field['key']);

                                        foreach ($subFieldObject['choices'] as $choice) {
                                            if (in_array($choice, $value)) {
                                                $capabilities[$choice] = true;
                                            } else {
                                                $capabilities[$choice] = false;
                                            }
                                        }

                                        $role[$replacedName] = $capabilities;
                                        break;

                                    default:

                                        if ($value !== '' && !is_null($value)) {
                                            $role[$replacedName] = $value;
                                        }
                                        break;

                                }
                            }

                            array_push($array, $role);
                        }
                    }
                }
            }
        }

        $this->_setRoles($array);
        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************************************/
    /********** EXISTING ROLE HAS TO BE DELETED **********/
    /*****************************************************/

    /*
     * @param String $name role formated name
     * @param Array $capabilities role capabilities
     * @return Bool
     */

    private function _existingRoleHasToBeDeleted(string $name, array $capabilities): bool
    {
        $existingRole = get_role($name);
        
        if ($existingRole) {
            foreach ($existingRole->capabilities as $c => $capability) {
                if ($capability !== $capabilities[$c]) {
                    return true;
                }
            }
        }

        return false;
    }
 
     /*********************************************************************************/
     /*********************************************************************************/
 
     /****************************************/
     /********** REGISTER USER ROLE **********/
     /****************************************/
 
     /*
      * @param Array $role the user role
      * @return Bool
      */ 
 
    private function _registerUserRole(array $role): bool
    {
        $existingRole = get_role($role['formated_name']);

        if ($existingRole && $this->_existingRoleHasToBeDeleted($role['formated_name'], $role['capabilities'])) {
            remove_role($role['formated_name']); 
        } elseif ($existingRole) {
            return true;
        }

        $result = add_role($role['formated_name'], $role['name'], $role['capabilities']);

        if ($result) {
            return true;
        }

        remove_role($role['formated_name']);
        return false;
    }
 
    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** LOOP OVER ROLES **********/
    /*************************************/

    private function _loopOverRoles()
    {
        if (!empty($this->_roles) && is_array($this->_roles)) {
            foreach ($this->_roles as $role) {
                $this->_registerUserRole($role);
            }
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** SET UP USER ROLES **********/
    /***************************************/
    
    public function setUpUserRoles()
    {
        $this->_parseUserRoles();
        $this->_loopOverRoles();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GENERATE PURGE PAGE **********/
    /*****************************************/

    public function generatePurgePage()
    {
        add_action( 'admin_menu', function() {
            add_submenu_page( 'theme-general-settings', 'Purge User Roles', 'Purge User Roles', 'manage_options', 'purge-user-roles', function() {

                if (!current_user_can( 'manage_options'))  {
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

}