<?php
/**
 * WP System - VisualSettingsStateFactory - Concrete Class
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
use App\Theme\States\VisualSettingStandardState as VisualSettingStandardState;

/**************************************************/
/********** VISUAL SETTING STATE FACTORY **********/
/**************************************************/

class VisualSettingStateFactory extends AbstractStateFactory
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
            default:
                return $this->_container->makeWith(VisualSettingStandardState::class, ['entity' => $entity]);
                break;
        }
        
    }
}