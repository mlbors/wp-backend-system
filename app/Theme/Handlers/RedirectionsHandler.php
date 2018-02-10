<?php
/**
 * WP System - RedirectionsHandler - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Handlers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IApplyer as IApplyer;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Abstracts\AbstractHandler as AbstractHandler;

/******************************************/
/********** REDIRECTIONS HANDLER **********/
/******************************************/

class RedirectionsHandler extends AbstractHandler implements IApplyer
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
        $this->apply();
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

        if ($request->args['type'] === 'redirection' && method_exists($this->_repository, $request->args['action'])) {
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

    /***************************/
    /********** APPLY **********/
    /***************************/

    public function apply()
    {
        $redirections = $this->_getRedirections();
        $this->_applyRedirections($redirections);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET REDIRECTIONS **********/
    /**************************************/

    /**
     * @return Array
     */

    protected function _getRedirections(): array
    {
        $request = $this->_requestService::buildRequest([
            'type' => 'redirection', 
            'action' => 'query'
            ], 
            [
            'method' => '', 
            'method_args' => [], 
            'query_args' => []
            ]);
        return $this->handleRequest($request);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** APPLY REDIRECTIONS **********/
    /****************************************/

    /**
     * @parma Array $array redirections array
     */

    protected function _applyRedirections(array $array)
    {
        foreach ($array as $redirection) {
            $request = $this->_requestService::buildRequest([
                'type' => 'redirection', 
                'action' => 'apply'
                ], 
                [
                'method' => '', 
                'method_args' => [], 
                'query_args' => ['redirection' => $redirection]
                ]);
            $result = $this->handleRequest($request);
        }
    }
}