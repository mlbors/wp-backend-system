<?php
/**
 * WP System - WPDBUsersContext - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Contexts;

use WP_Query;
use WP_User;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Abstracts\AbstractContext as AbstractContext;

/*****************************************/
/********** WP DB USERS CONTEXT **********/
/*****************************************/

class WPDBUsersContext extends AbstractContext
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
    /********** QUERY USER **********/
    /********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */

    protected function _queryUser($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['ID'])) {
            return false;
        }

        return new WP_User($queryArgs['ID']);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** QUERY USER CURRENT **********/
    /****************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */
    
    protected function _queryUserCurrent($methodArgs, $queryArgs)
    {
        return new WP_User(get_current_user_id());
    }
}