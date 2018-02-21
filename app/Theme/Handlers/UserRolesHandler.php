<?php
/**
 * WP System - UserRolesHandler - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Handlers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IRegister as IRegister;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Abstracts\AbstractHandler as AbstractHandler;

/****************************************/
/********** USER ROLES HANDLER **********/
/****************************************/

class UserRolesHandler extends AbstractHandler implements IRegister
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IRepositoryBuilder $repositoryBuilder object that creates repositories
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IRepositoryBuilder $repositoryBuilder, string $requestService)
    {
        parent::__construct($repositoryBuilder, $requestService);  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        $this->register();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CAN HANDLE REQUEST **********/
    /****************************************/

    /**
     * @return Bool
     */

    public function canHandleRequest(IRequest $request): bool
    {
        if (empty($request->args['type']) || empty($request->args['action'])) {
            return false;
        }

        if ($request->args['type'] === 'role' && method_exists($this->_repository, $request->args['action'])) {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** HANDLE REQUEST **********/
    /************************************/

    public function handleRequest(IRequest $request)
    {
        $action = $request->args['action'];
        $result = $this->_repository->{"$action"}($request->constraints);
        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** REGISTER **********/
    /******************************/

    public function register()
    {
        $roles = $this->_getUserRoles();
        $this->_registerUserRoles($roles);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GET CPT **********/
    /*****************************/

    /**
     * @return Array
     */

    protected function _getUserRoles(): array
    {
        $array = [];
        $request = $this->_requestService::buildRequest([
            'type' => 'role', 
            'action' => 'query'
            ], 
            [
            'method' => '', 
            'method_args' => [], 
            'query_args' => []
            ]);
        $result = $this->handleRequest($request);

        if (!empty($result) && is_array($result)) {
            $array = $result;
        }

        return $array;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** REGISTER USER ROLES **********/
    /*****************************************/

    /**
     * @parma Array $array user roles array
     */

    protected function _registerUserRoles(array $array)
    {
        foreach ($array as $role) {
            $request = $this->_requestService::buildRequest([
                'type' => 'role', 
                'action' => 'register'
                ], 
                [
                'method' => '', 
                'method_args' => [], 
                'query_args' => ['role' => $role]
                ]);
            $result = $this->handleRequest($request);
        }
    }
}