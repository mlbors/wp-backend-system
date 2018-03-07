<?php
/**
 * WP System - OptionDisableCommentsState - Concrete Class
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

/***************************************************/
/********** OPTION DISABLE COMMENTS STATE **********/
/***************************************************/

class OptionDisableCommentsState extends AbstractOptionState
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