<?php
/**
 * WP System - OptionsHandler - Abstract Class
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

/*************************************/
/********** OPTIONS HANDLER **********/
/*************************************/

class OptionsHandler extends AbstractHandler implements IApplyer
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

        if ($request->args['type'] === 'option' && method_exists($this->_repository, $request->args['action'])) {
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
        $options = $this->_getOptions();
        $this->_applyOptions($options);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** GET OPTIONS **********/
    /*********************************/

    /**
     * @return Array
     */

    protected function _getOptions(): array
    {
        $request = $this->_requestService::buildRequest([
            'type' => 'option', 
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

    /***********************************/
    /********** APPLY OPTIONS **********/
    /***********************************/

    /**
     * @parma Array $array options array
     */

    protected function _applyOptions(array $array)
    {
        foreach ($array as $option) {
            $request = $this->_requestService::buildRequest([
                'type' => 'option', 
                'action' => 'apply'
                ], 
                [
                'method' => '', 
                'method_args' => [], 
                'query_args' => ['option' => $option]
                ]);
            $result = $this->handleRequest($request);
        }
    }
}