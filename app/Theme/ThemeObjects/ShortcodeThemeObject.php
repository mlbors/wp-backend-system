<?php
/**
 * WP System - ShortcodeThemeObject - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IShortcode as IShortcode;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Interfaces\IStateFactory as IStateFactory;
use App\Theme\Interfaces\ITransientServiceBuilder as ITransientServiceBuilder;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;

/********************************************/
/********** SHORTCODE THEME OBJECT **********/
/********************************************/

class ShortcodeThemeObject extends AbstractThemeObject implements IShortcode
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IState $_state object's state
     * @var IStateFactory $_stateFactory object that creates states
     * @var String $_transientService object that manages transients (static class)
     * @var ITransientServiceBuilder $_transientServiceBuilder object that creates tansient service
     * @var String $_requestService object that manages requests (static class)
     */

    protected $_state;
    protected $_stateFactory;
    protected $_transientService;
    protected $_transientServiceBuilder;
    protected $_requestService;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     * @param IStateFactory $stateFactory object that creates states
     * @param ITransientServiceBuilder $transientServiceBuilder object that creates tansient service
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IEntity $entity, IStateFactory $stateFactory, ITransientServiceBuilder $transientServiceBuilder, string $requestService)
    {
        parent::__construct($entity);
        $this->_setShortcodeValues($stateFactory, $transientServiceBuilder, $requestService);    
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** SET OPTION VALUES **********/
    /***************************************/

    /**
     * @param IStateFactory $stateFactory object that creates states
     * @param ITransientServiceBuilder $transientServiceBuilder object that creates tansient service
     * @vparam String $requestService object that manages requests (static class)
     */

    protected function _setShortcodeValues(IStateFactory $stateFactory, ITransientServiceBuilder $transientServiceBuilder, string $requestService)
    {   
        $this->_setStateFactory($stateFactory);
        $this->_setTransientServiceBuilder($transientServiceBuilder);
        $this->_setRequestService($requestService);
        $this->_instantiateTransientService();
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
    
    /*******************************************/
    /********** SET TRANSIENT SERVICE **********/
    /*******************************************/

    /**
     * @param String $transientService object that manages transients (static class)
     */

    protected function _setTransientService($transientService)
    {
        $this->_transientService = $transientService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************************/
    /********** SET TRANSIENT SERVICE BUILDER **********/
    /***************************************************/

    /**
     * @param ITransientServiceBuilder $transientServiceBuilder object that creates tansient service
     */

    protected function _setTransientServiceBuilder(ITransientServiceBuilder $transientServiceBuilder)
    {
        $this->_transientServiceBuilder = $transientServiceBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setRequestService(string $requestService)
    {
        $this->_requestService = $requestService;
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

    /*******************************************/
    /********** GET TRANSIENT SERVICE **********/
    /*******************************************/

    /**
     * @return string
     */

    public function getTransientService()
    {
        return $this->_transientService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************************/
    /********** GET TRANSIENT SERVICE BUILDER **********/
    /***************************************************/

    /**
     * @return ITransientServiceBuilder
     */

    public function getTransientServiceBuilder(): ITransientServiceBuilder
    {
        return $this->_transientServiceBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @return String
     */

    public function getRequestService(): string
    {
        return $this->_requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************************/
    /********** INSTANTIATE TRANSIENT SERVICE **********/
    /***************************************************/

    protected function _instantiateTransientService()
    {
        $this->_setTransientService($this->_transientServiceBuilder->create());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** INSTANTIATE STATE **********/
    /***************************************/

    protected function _instantiateState()
    {
        $this->_stateFactory->setTransientService($this->_transientService);
        $this->_stateFactory->setRequestService($this->_requestService);
        $this->_setState($this->_stateFactory->create((string)$this->_entity->type, $this->_entity));
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** REGISTER **********/
    /******************************/

    public function register()
    {
        $this->_state->execute();
    }
}