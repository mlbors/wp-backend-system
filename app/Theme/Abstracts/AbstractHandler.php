<?php
/**
 * WP System - AbstractHandler - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IChainHandler as IChainHandler;
use App\Theme\Interfaces\IHandler as IHandler;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRepository as IRepository;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;

/**************************************/
/********** ABSTRACT HANDLER **********/
/**************************************/

abstract class AbstractHandler implements IHandler, IChainHandler
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IRepository $_repository repository object
     * @var IRepositoryBuilder $_repositoryBuilder object that creates repositories
     * @var String $_requestService object that manages requests (static class)
     */

    protected $_repository;
    protected $_repositoryBuilder;
    protected $_requestService;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IRepositoryBuilder $repositoryBuilder object that creates repositories
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IRepositoryBuilder $repositoryBuilder, string $requestService)
    {
        $this->_setValues($repositoryBuilder, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    abstract public function init();

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IRepositoryBuilder $repositoryBuilder object that creates repositories
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setValues(IRepositoryBuilder $repositoryBuilder, string $requestService)
    {
        $this->_setRequestService($requestService);
        $this->_setRepositoryBuilder($repositoryBuilder);
        $this->_instantiateRepository($requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET REPOSITORY **********/
    /************************************/

    /**
     * @param IRepository $repository repository object
     */

    protected function _setRepository(IRepository $repository)
    {
        $this->_repository = $repository;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** SET REPOSITORY BUILDER **********/
    /********************************************/

    /**
     * @param IRepositoryBuilder $repositoryBuilder object that creates repositories
     */

    protected function _setRepositoryBuilder(IRepositoryBuilder $repositoryBuilder)
    {
        $this->_repositoryBuilder = $repositoryBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setRequestService(string $requestService)
    {
        $this->_requestService = $requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** GET REPOSITORY **********/
    /************************************/

    /**
     * @return IRepository
     */

    public function getRepository(): IRepository
    {
        return $this->_repository;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** GET REPOSITORY BUILDER **********/
    /********************************************/

    /**
     * @return IRepositoryBuilder
     */

    public function getRepositoryBuilder(): IRepositoryBuilder
    {
        return $this->_repositoryBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @return String
     */

    public function getRequestService(): string
    {
        return $this->_requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** INSTANTIATE REPOSITORY **********/
    /********************************************/

    protected function _instantiateRepository()
    {
        $this->_setRepository($this->_repositoryBuilder->create($this->_requestService));
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** SWAP REPOSITORY **********/
    /*************************************/

    /**
     * @param IRepositoryBuilder $repositoryBuilder object that creates repositories
     */

    public function swapRepository(IRepositoryBuilder $repositoryBuilder)
    {
        $this->_setRepositoryBuilder($repositoryBuilder);
        $this->_instantiateRepository();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CAN HANDLE REQUEST **********/
    /****************************************/

    abstract public function canHandleRequest(IRequest $request): bool;

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** HANDLE REQUEST **********/
    /************************************/

    abstract public function handleRequest(IRequest $request);
}