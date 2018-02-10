<?php
/**
 * WP System - OptionStateFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractStateFactory as AbstractStateFactory;
use App\Theme\States\OptionDisableCommentState as OptionDisableCommentState;
use App\Theme\States\OptionHideAdminBarState as OptionHideAdminBarState;
use App\Theme\States\OptionRemoveOptionsAdminBarState as OptionRemoveOptionsAdminBarState;
use App\Theme\States\OptionRemoveDashboardMetaBoxState as OptionRemoveDashboardMetaBoxState;
use App\Theme\States\OptionRemoveUpdateNotificationsState as OptionRemoveUpdateNotificationsState;
use App\Theme\States\OptionHideMenuToUsersState as OptionHideMenuToUsersState;
use App\Theme\States\OptionHideOptionsToUsersState as OptionHideOptionsToUsersState;
use App\Theme\States\OptionAddQueryArgsState as OptionAddQueryArgsState;
use App\Theme\States\OptionAddImageSizesState as OptionAddImageSizesState;
use App\Theme\States\OptionAddMimesState as OptionAddMimesState;
use App\Theme\States\OptionStandardState as OptionStandardState;

/******************************************/
/********** OPTION STATE FACTORY **********/
/******************************************/

class OptionStateFactory extends AbstractStateFactory
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** CREATE STATE **********/
    /**********************************/

    /**
     * @param String $state targeted $state
     * @param IEntity $entity redirection entity
     * @return IState
     */

    protected function _createState(string $state, IEntity $entity): IState
    {
        switch($state) {
            case 'disable_comments':
                return $this->_container->makeWith(OptionDisableCommentState::class, ['entity' => $entity]);
                break;
            case 'hide_admin_bar':
                return $this->_container->makeWith(OptionHideAdminBarState::class, ['entity' => $entity]);
                break;
            case 'remove_options_admin_bar':
                return $this->_container->makeWith(OptionRemoveOptionsAdminBarState::class, ['entity' => $entity]);
                break;
            case 'remove_dashboard_meta_box':
                return $this->_container->makeWith(OptionRemoveDashboardMetaBoxState::class, ['entity' => $entity]);
                break;
            case 'remove_update_notifications':
                return $this->_container->makeWith(OptionRemoveUpdateNotificationsState::class, ['entity' => $entity]);
                break;            
            case 'hide_menus_to_users':
                return $this->_container->makeWith(OptionHideMenuToUsersState::class, ['entity' => $entity]);
                break;            
            case 'hide_options_to_users':
                return $this->_container->makeWith(OptionHideOptionsToUsersState::class, ['entity' => $entity]);
                break;            
            case 'add_query_args':
                return $this->_container->makeWith(OptionAddQueryArgsState::class, ['entity' => $entity]);
                break;
            case 'add_image_sizes':
                return $this->_container->makeWith(OptionAddImageSizesState::class, ['entity' => $entity]);
                break;
            case 'add_mimes':
                return $this->_container->makeWith(OptionAddMimesState::class, ['entity' => $entity]);
                break;
            default:
                return $this->_container->makeWith(OptionStandardState::class, ['entity' => $entity]);
                break;
        }
        
    }
}