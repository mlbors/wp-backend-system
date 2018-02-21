<?php
/**
 * WP System - APISHandler - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Handlers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IGetter as IGetter;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Abstracts\AbstractHandler as AbstractHandler;

/**********************************/
/********** APIS HANDLER **********/
/**********************************/

class APISHandler extends AbstractHandler
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
        $this->get();
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

        if ($request->args['type'] === 'api' && method_exists($this->_repository, $request->args['action'])) {
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

    /*************************/
    /********** GET **********/
    /*************************/

    public function get()
    {
        $apis = $this->_getAPIS();
        return $apis;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET APIS **********/
    /******************************/

    /**
     * @return Array
     */

    protected function _getAPIS(): array
    {
        $array = [];
        $request = $this->_requestService::buildRequest([
            'type' => 'api', 
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
}