<?php
/**
 * WP System - APIThemeObject - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;

/**************************************/
/********** API THEME OBJECT **********/
/**************************************/

class APIThemeObject extends AbstractThemeObject
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
}