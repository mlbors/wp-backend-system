<?php
/**
 * WP System - VisualSettingThemeObject - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Interfaces\IStateFactory as IStateFactory;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;

/*************************************************/
/********** VISUAL SETTING THEME OBJECT **********/
/*************************************************/

class VisualSettingThemeObject extends AbstractThemeObject
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IState $_state object's state
     * @var IStateFactory $_stateFactory object that creates states
     */

    protected $_state;
    protected $_stateFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     * @param IStateFactory $_stateFactory object that creates states
     */

    public function __construct(IEntity $entity, IStateFactory $stateFactory)
    {
        parent::__construct($entity);
        $this->_setVisualSettingValues($stateFactory);   
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** SET VISUAL SETTING VALUES **********/
    /***********************************************/

    /**
     * @param IStateFactory $stateFactory object that creates states
     */

    protected function _setVisualSettingValues(IStateFactory $stateFactory)
    {   
        $this->_setStateFactory($stateFactory);
        $this->_instantiateState();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** SET STATE FACTORY **********/
    /***************************************/

    /**
     * @param IStateFactory $stateFactory object that creates states
     */

    protected function _setStateFactory(IStateFactory $stateFactory)
    {   
        $this->_stateFactory = $stateFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** SET STATE **********/
    /*******************************/

    /**
     * @param IState $_state object's state
     */

    protected function _setState(IState $state)
    {   
        $this->_state = $state;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** GET STATE FACTORY **********/
    /***************************************/

    /**
     * @return IStateFactory
     */

    public function getStateFactory(): IStateFactory
    {   
        return $this->_stateFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** GET STATE **********/
    /*******************************/

    /**
     * @return IState
     */

    public function getState(): IState
    {   
        return $this->_state;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** INSTANTIATE STATE **********/
    /***************************************/

    protected function _instantiateState()
    {
        $this->_setState($this->_stateFactory->create((string)$this->_entity->type, $this->_entity));
    }
}