<?php
/**
 * WP System - OptionRemoveUpdateNotificationsState - Concrete Class
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

/**************************************************************/
/********** OPTION REMOVE UPDATE NOTIFICATIONS STATE **********/
/**************************************************************/

class OptionRemoveUpdateNotificationsState extends AbstractOptionState
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

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_applyOption();
    }
}