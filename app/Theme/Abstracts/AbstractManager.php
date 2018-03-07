<?php
/**
 * WP System - AbstractManager - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IHandler as IHandler;
use App\Theme\Interfaces\IHandlerFactory as IHandlerFactory;
use App\Theme\Interfaces\IManager as IManager;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequestServiceBuilder as IRequestServiceBuilder;

/**************************************/
/********** ABSTRACT MANAGER **********/
/**************************************/

abstract class AbstractManager implements IManager
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Array $_handlers array of handlers
     * @var Array $_handlerFactory array object that creates handlers
     * @var IRequestService $_requestService object that manages requests
     * @var IRequestServiceBuilder $_requestServiceBuilder object that creates request services
     */

    protected $_handlers = [];
    protected $_handlerFactories = [];
    protected $_requestService;
    protected $_requestServiceBuilder;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param Array $handlersFactories array object that creates handlers
     * @param IRequestServiceBuilder $_requestServiceBuilder object that creates request services
     */

    public function __construct(array $handlersFactories, IRequestServiceBuilder $requestServiceBuilder)
    {
        $this->_setValues($handlersFactories, $requestServiceBuilder);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    abstract public function init();

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** INIT HANDLERS **********/
    /***********************************/

    public function initHandlers()
    {
        foreach($this->_handlers as $handler) {
            $handler->init();
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param Array $handlersFactories array object that creates handlers
     * @param IRequestServiceBuilder $_requestServiceBuilder object that creates request services
     */

    protected function _setValues(array $handlersFactories, IRequestServiceBuilder $requestServiceBuilder)
    {
        $this->_setRequestServiceBuilder($requestServiceBuilder);
        $this->_instantiateRequestService();
        $this->_setHandlerFactories($handlersFactories);   
        $this->_instantiateHandlers();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SET HANDLERS **********/
    /**********************************/

    /**
     * @param Array $handlers array of handlers
     */

    public function setHandlers(array $handlers)
    {
        $this->_handlers = $handlers;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** SET HANDLER FACTORIES **********/
    /*******************************************/

    /**
     * @param Array $_handlerFactory array object that creates handlers
     */

    protected function _setHandlerFactories(array $handlerFactories)
    {
        $this->_handlerFactories = $handlerFactories;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @param IRequestService $requestService object that manages requests
     */

    protected function _setRequestService($requestService)
    {
        $this->_requestService = $requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** SET REQUEST SERVICE BUILDER **********/
    /*************************************************/

    /**
     * @param IRequestServiceBuilder $_requestServiceBuilder object that creates request services
     */

    protected function _setRequestServiceBuilder(IRequestServiceBuilder $requestServiceBuilder)
    {
        $this->_requestServiceBuilder = $requestServiceBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET HANDLERS **********/
    /**********************************/

    /**
     * @return Array
     */

    public function getHandlers(): array
    {
        return $this->_handlers;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GET HANDLER FACTORIES **********/
    /*******************************************/

    /**
     * @return Array
     */

    public function getHandlerFactories(): Array
    {
        return $this->_handlerFactories;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @return IRequestService
     */

    public function getRequestService()
    {
        return $this->_requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** GET REQUEST SERVICE BUILDER **********/
    /*************************************************/

    /**
     * @return IRequestServiceBuilder
     */

    public function getRequestServiceBuilder(): IRequestServiceBuilder
    {
        return $this->_requestServiceBuilder;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET SETTINGS **********/
    /**********************************/

    abstract public function getSettings(): array;

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** PUSH HANDLER **********/
    /**********************************/

    /**
     * @param IHandler $handler handler object
     */

    protected function _pushHandler(IHandler $handler)
    {
        array_push($this->_handlers, $handler);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** PUSH HANDLER FACTORY **********/
    /******************************************/

    /**
     * @param IHandlerFactory $handlerFactory object that creates handlers
     */

    protected function _pushHandlerFactory(IHandlerFactory $handlerFactory)
    {
        array_push($this->_handlerFactories, $handlerFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** INSTANTIATE HANDLERS **********/
    /******************************************/

    protected function _instantiateHandlers()
    {
        foreach($this->_handlerFactories as $factory) {
            $this->_pushHandler($factory->create($this->_requestService));
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** INSTANTIATE REQUEST SERVICE **********/
    /*************************************************/

    protected function _instantiateRequestService()
    {
        $requestService = $this->_requestServiceBuilder->create($this);
        $this->_setRequestService($requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** REGISTER FACTORY **********/
    /**************************************/

    /**
     * @param IHandlerFactory $handlerFactory object that creates handlers
     */

    protected function _registerHandlerFactory(IHandlerFactory $handlerFactory)
    {
        $this->_pushHandlerFactory($handlerFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** REGISTER HANDLER **********/
    /**************************************/

    /**
     * @param IHandlerFactory $handlerFactory object that creates handlers
     */

    public function registerHandler(IHandlerFactory $handlerFactory)
    {
        $this->_registerHandlerFactory($handlerFactory);
        $this->_pushHandler($handlerFactory->create($this->_requestService));
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** DISPATCH REQUEST **********/
    /**************************************/

    /**
     * @return Mixed
     */

    public function dispatchRequest(IRequest $request)
    {
        foreach($this->_handlers as $handler) {
            if ($handler->canHandleRequest($request)) {
                return $handler->handleRequest($request);
            }
        }
        return false;
    }
}