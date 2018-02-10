<?php
/**
 * WP System - UserThemeObject - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;

/***************************************/
/********** USER THEME OBJECT **********/
/***************************************/

class UserThemeObject extends AbstractThemeObject
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

        /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GET USER ROLE **********/
    /***********************************/

    /**
     * @return Mixed String || False
     */

    public function getUserRole() 
    { 
        if (empty((int)$this->_entity->ID)) {
            return false;
        }
        return (string) $this->_entity->roles[0];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** GET USER DATA **********/
    /***********************************/

    /**
     * @return Mixed Array || False
     */

    public function getUserData()
    {
        if (empty((int)$this->_entity->ID)) {
            return false;
        }

        return (array)$this->_entity->data;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GET CURRENT USER DATA **********/
    /*******************************************/

    /**
     * @return Mixed Array || False
     */

    public function getCurrentUserData()
    {
        if (!is_user_logged_in()) {
            return false;
        }

        $array = [];

        $array['data'] = $this->getUserData();
        $array['role'] = $this->getUserRole();

        return $array;
    }
}