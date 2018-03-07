<?php
/**
 * WP System - CPTHandler - Abstract Class
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

/*********************************/
/********** CPT HANDLER **********/
/*********************************/

class CPTHandler extends AbstractHandler implements IRegister
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

        if ($request->args['type'] === 'cpt' && method_exists($this->_repository, $request->args['action'])) {
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
        $cpt = $this->_getCPT();
        $this->_registerCPT($cpt);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GET CPT **********/
    /*****************************/

    /**
     * @return Array
     */

    protected function _getCPT(): array
    {
        $array = [];
        $request = $this->_requestService::buildRequest([
            'type' => 'cpt', 
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

    /**********************************/
    /********** REGISTER CPT **********/
    /**********************************/

    /**
     * @parma Array $array CPT array
     */

    protected function _registerCPT(array $array)
    {
        foreach ($array as $cpt) {
            $request = $this->_requestService::buildRequest([
                'type' => 'cpt', 
                'action' => 'register'
                ], 
                [
                'method' => '', 
                'method_args' => [], 
                'query_args' => [$cpt->getData()]
                ]);
            $result = $this->handleRequest($request);
        }
    }
}