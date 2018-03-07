<?php
/**
 * WP System - UsersHandler - Abstract Class
 *
 * @since       2018.01.12
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

/***********************************/
/********** USERS HANDLER **********/
/***********************************/

class UsersHandler extends AbstractHandler
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

        if ($request->args['type'] === 'user' && method_exists($this->_repository, $request->args['action'])) {
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
}