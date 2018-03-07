<?php
/**
 * WP System - UsersRolesHandlerFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IHandler as IHandler;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Abstracts\AbstractHandlerFactory as AbstractHandlerFactory;
use App\Theme\Builders\UserRolesRepositoryBuilder as UserRolesRepositoryBuilder;
use App\Theme\Handlers\UserRolesHandler as UserRolesHandler;

/************************************************/
/********** USER ROLES HANDLER FACTORY **********/
/************************************************/

class UserRolesHandlerFactory extends AbstractHandlerFactory
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

    /*******************************************/
    /********** SET REPOSITORY BUIDER **********/
    /*******************************************/

    protected function _setRepositoryBuilder()
    {
        $this->_repositoryBuilder = $this->_container->make(UserRolesRepositoryBuilder::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE HANDLER **********/
    /************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     * @return IHandler
     */

    protected function _createHandler($requestService): IHandler
    {
        return $this->_container->makeWith(UserRolesHandler::class, ['repositoryBuilder' => $this->_repositoryBuilder, 'requestService' => $requestService]);
    }
}