<?php
/**
 * WP System - RedirectionThemeObjectBuilder - Concrete Class
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
use App\Theme\Abstracts\AbstractThemeObjectBuilder as AbstractThemeObjectBuilder;
use App\Theme\Factories\RedirectionStateFactory as RedirectionStateFactory;
use App\Theme\ThemeObjects\RedirectionThemeObject as RedirectionThemeObject;

/******************************************************/
/********** REDIRECTION THEME OBJECT BUILDER **********/
/******************************************************/

class RedirectionThemeObjectBuilder extends AbstractThemeObjectBuilder
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IStateFactory $_stateFactory object that creates states
     */

    protected $_stateFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
        $this->_setStateFactory();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** SET STATE FACTORY **********/
    /***************************************/

    protected function _setStateFactory()
    {
        $this->_stateFactory = $this->_container->make(RedirectionStateFactory::class);
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
        return $this->_container->makeWith(RedirectionThemeObject::class, ['entity' => $entity, 'stateFactory' => $this->_stateFactory]);
    }
}