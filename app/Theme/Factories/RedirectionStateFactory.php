<?php
/**
 * WP System - RedirectionStateFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractStateFactory as AbstractStateFactory;
use App\Theme\States\Redirection404State as Redirection404State;
use App\Theme\States\RedirectionAdminState as RedirectionAdminState;
use App\Theme\States\RedirectionAttachementState as RedirectionAttachementState;
use App\Theme\States\RedirectionLoggedState as RedirectionLoggedState;
use App\Theme\States\RedirectionNotLoggedState as RedirectionNotLoggedState;
use App\Theme\States\RedirectionStandardState as RedirectionStandardState;

/***********************************************/
/********** REDIRECTION STATE FACTORY **********/
/***********************************************/

class RedirectionStateFactory extends AbstractStateFactory
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
            case 'admin_redirect':
                return $this->_container->makeWith(RedirectionAdminState::class, ['entity' => $entity]);
                break;
            case '404_redirect':
                return $this->_container->makeWith(Redirection404State::class, ['entity' => $entity]);
                break;
            case 'attachement_redirect':
                return $this->_container->makeWith(RedirectionAttachementState::class, ['entity' => $entity]);
                break;
            case 'is_logged':
                return $this->_container->makeWith(RedirectionLoggedState::class, ['entity' => $entity]);
                break;
            case 'not_logged':
                return $this->_container->makeWith(RedirectionNotLoggedState::class, ['entity' => $entity]);
                break;
            default: 
                return $this->_container->makeWith(RedirectionStandardState::class, ['entity' => $entity]);
                break;
        }
    }
}