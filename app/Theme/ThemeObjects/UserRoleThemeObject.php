<?php
/**
 * WP System - UserRoleThemeObject - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;

/********************************************/
/********** USER ROLE THEME OBJECT **********/
/********************************************/

class UserRoleThemeObject extends AbstractThemeObject
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
    
    /*******************************************************/
    /********** CHECK IF CAPABILITES ARE OUTDATED **********/
    /*******************************************************/

    /**
     * @param Array $capabilities role capabilities
     * @return Bool
     */

    public function checkIfCapabilitesAreOutdated(array $capabilities = []): bool
    {
        if (empty((string)$this->_entity->name)) {
            return false;
        }

        $role = get_role($this->_entity->formated_name);
        
        if ($role) {
            foreach ($role->capabilities as $c => $capability) {
                if ($capability !== $capabilities[$c]) {
                    return true;
                }
            }
        }

        return false;
    }
}