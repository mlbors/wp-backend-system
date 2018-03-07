<?php
/**
 * WP System - OptionHideMenuToUsersState - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\States;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractOptionState as AbstractOptionState;

/*****************************************************/
/********** OPTION HIDE MNEU TO USERS STATE **********/
/*****************************************************/

class OptionHideMenuToUsersState extends AbstractOptionState
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     */

    public function __construct(IEntity $entity)
    {
        parent::__construct($entity);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** APPLY OPTION **********/
    /**********************************/

    protected function _applyOption() 
    {
        if (is_admin()) {

            $entity = $this->_entity;
            add_action('admin_menu', function() use($entity) {

                $user = wp_get_current_user();
                $usersList = explode(",", $this->_entity->value);

                if (in_array($user->user_login, $usersList)) {

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

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_applyOption();
    }
}