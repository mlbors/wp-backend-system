<?php
/**
 * WP System - OptionRemoveOptionsAdminBarState - Concrete Class
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

/***********************************************************/
/********** OPTION REMOVE OPTIONS ADMIN BAR STATE **********/
/***********************************************************/

class OptionRemoveOptionsAdminBarState extends AbstractOptionState
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

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_applyOption();
    }
}