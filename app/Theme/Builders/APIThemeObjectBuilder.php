<?php
/**
 * WP System - APIThemeObjectBuilder - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Interfaces\IThemeObject as IThemeObject;
use App\Theme\Abstracts\AbstractThemeObjectBuilder as AbstractThemeObjectBuilder;
use App\Theme\ThemeObjects\APIThemeObject as APIThemeObject;

/**********************************************/
/********** API THEME OBJECT BUILDER **********/
/**********************************************/

class APIThemeObjectBuilder extends AbstractThemeObjectBuilder
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
        return $this->_container->makeWith(APIThemeObject::class, ['entity' => $entity]);
    }
}