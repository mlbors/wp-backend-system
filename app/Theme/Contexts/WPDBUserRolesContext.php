<?php
/**
 * WP System - WPDBUserRolesContext - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Contexts;

use WP_Query;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Abstracts\AbstractContext as AbstractContext;
use App\Theme\Helpers\ACFFieldsHelper as ACFFieldsHelper;

/**********************************************/
/********** WP DB USER ROLES CONTEXT **********/
/**********************************************/

class WPDBUserRolesContext extends AbstractContext
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntityFactory $entityFactory object that create entities
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IEntityFactory $entityFactory, string $requestService)
    {
        parent::__construct($entityFactory, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** QUERY ROLE **********/
    /********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */
    protected function _queryRole($methodArgs, $queryArgs)
    {
        $result = [];
        $roles = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-user-roles', ['custom_user_roles_']);

        foreach($roles as $v => $value) {
            array_push($result, (object)$value);
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** REGISTER ROLE **********/
    /***********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Bool
     */

    protected function _registerRole($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs)) {
            return false;
        }

        $data = $queryArgs['role']->getData();
        $existingRole = get_role($data->formated_name);

        if ($existingRole && $queryArgs['role']->checkIfCapabilitesAreOutdated($data->capabilities)) {
            remove_role($data->formated_name); 
        } elseif ($existingRole) {
            return true;
        }

        $result = add_role($data->formated_name, $data->name, $data->capabilities);

        if ($result) {
            return true;
        }

        remove_role($data->formated_name);
        return false;
    }
}