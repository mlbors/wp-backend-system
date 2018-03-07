<?php
/**
 * WP System - CTThemeObject - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;

/*************************************/
/********** CT THEME OBJECT **********/
/*************************************/

class CTThemeObject extends AbstractThemeObject
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