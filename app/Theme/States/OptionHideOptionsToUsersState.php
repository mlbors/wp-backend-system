<?php
/**
 * WP System - OptionHideOptionsToUsersState - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\States;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractOptionState as AbstractOptionState;

/********************************************************/
/********** OPTION HIDE OPTIONS TO USERS STATE **********/
/********************************************************/

class OptionHideOptionsToUsersState extends AbstractOptionState
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
            add_action('admin_init', function() use($entity) {

                $user = wp_get_current_user();
                $usersList = explode(",", $this->_entity->value);
                
                if (in_array($user->user_login, $usersList)) {
                    
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

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_applyOption();
    }
}