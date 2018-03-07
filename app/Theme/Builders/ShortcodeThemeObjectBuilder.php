<?php
/**
 * WP System - ShortcodeThemeObjectBuilder - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IStateFactory as IStateFactory;
use App\Theme\Interfaces\IThemeObject as IThemeObject;
use App\Theme\Interfaces\ITransientServiceBuilder as ITransientServiceBuilder;
use App\Theme\Abstracts\AbstractThemeObjectBuilder as AbstractThemeObjectBuilder;
use App\Theme\Factories\ShortcodeStateFactory as ShortcodeStateFactory;
use App\Theme\ThemeObjects\ShortcodeThemeObject as ShortcodeThemeObject;

/****************************************************/
/********** SHORTCODE THEME OBJECT BUILDER **********/
/****************************************************/

class ShortcodeThemeObjectBuilder extends AbstractThemeObjectBuilder
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IStateFactory $_stateFactory object that creates states
     * @var String $_requestService object that manages requests (static class)
     * @var ITransientServiceBuilder $_transientServiceBuilder object that creates transient service
     */

    protected $_stateFactory;
    protected $_requestService;
    protected $_transientServiceBuilder;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
        $this->_setBuilderValues();
    }   

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** SET BUILDER VALUES **********/
    /****************************************/

    protected function _setBuilderValues()
    {
        $this->_setStateFactory();
        $this->_setTransientServiceBuilder();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** SET STATE FACTORY **********/
    /***************************************/

    protected function _setStateFactory()
    {
        $this->_stateFactory = $this->_container->make(ShortcodeStateFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************************/
    /********** SET TRANSIENT SERVICE BUILDER **********/
    /***************************************************/

    protected function _setTransientServiceBuilder()
    {
        $this->_transientServiceBuilder = $this->_container->make(TransientServiceBuilder::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setRequestSerivce(string $requestService)
    {
        $this->_requestService = $requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** PREPARE BUILDER **********/
    /*************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    public function prepareBuilder(string $requestService)
    {
        $this->_setRequestSerivce($requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** CREATE THEME OBJECT **********/
    /*****************************************/

    /**
     * @param IEntity $entity entity object
     * @return IThemeObject
     */

    protected function _createThemeObject(IEntity $entity): IThemeObject
    {
        return $this->_container->makeWith(ShortcodeThemeObject::class, ['entity' => $entity, 'stateFactory' => $this->_stateFactory, 'transientServiceBuilder' => $this->_transientServiceBuilder, 'requestService' => $this->_requestService]);
    }
}