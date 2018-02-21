<?php
/**
 * WP System - WidgetThemeObjectBuilder - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IThemeObject as IThemeObject;
use App\Theme\Abstracts\AbstractThemeObjectBuilder as AbstractThemeObjectBuilder;
use App\Theme\ThemeObjects\WidgetThemeObject as WidgetThemeObject;

/*************************************************/
/********** WIDGET THEME OBJECT BUILDER **********/
/*************************************************/

class WidgetThemeObjectBuilder extends AbstractThemeObjectBuilder
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

    /*****************************************/
    /********** CREATE THEME OBJECT **********/
    /*****************************************/

    /**
     * @param IEntity $entity entity object
     * @return IThemeObject
     */

    protected function _createThemeObject(IEntity $entity): IThemeObject
    {
        return $this->_container->makeWith(WidgetThemeObject::class, ['entity' => $entity]);
    }
}