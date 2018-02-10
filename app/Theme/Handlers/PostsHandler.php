<?php
/**
 * WP System - PostsHandler - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Handlers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Abstracts\AbstractHandler as AbstractHandler;

/***********************************/
/********** POSTS HANDLER **********/
/***********************************/

class PostsHandler extends AbstractHandler
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
        /*$this->_requestService::buildRequestAndExecute([
                                                        'type' => 'post', 
                                                        'action' => 'query'
                                                        ], 
                                                        [
                                                        'method' => '', 
                                                        'method_args' => ['method' => 'get'], 
                                                        'query_args' => ['args' => []]
                                                        ]);

        $this->_requestService::buildRequestAndExecute([
                                                        'type' => 'post', 
                                                        'action' => 'query'
                                                        ], 
                                                        [
                                                        'method' => 'ByID', 
                                                        'method_args' => [], 
                                                        'query_args' => ['ID' => 5]
                                                        ]);

        /*$postData = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-cpt', 'option_custom_post_types_');
        echo '<pre>';
        echo 'post data cpt<br />';
        print_r($postData);
        echo '</pre>';

        $postData = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-redirections', 'custom_redirections_redirections_');
        echo '<pre>';
        echo 'post data redirections<br />';
        print_r($postData);
        echo '</pre>';*/
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

        if ($request->args['type'] === 'post' && method_exists($this->_repository, $request->args['action'])) {
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