<?php
/**
 * WP System - AbstractHandlerFactory - Abstract Class
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
use App\Theme\Interfaces\IRequestService as IRequestService;

/**********************************************/
/********** ABSTRACT HANDLER FACTORY **********/
/**********************************************/

abstract class AbstractHandlerFactory implements IHandlerFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var IRepositoryBuilder $_repositoryBuilder object that builds repositories
     */

    protected $_container;
    protected $_repositoryBuilder;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        $this->_setValues();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    protected function _setValues()
    {
        $this->_setContainer();
        $this->_setRepositoryBuilder();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** SET CONTAINER **********/
    /***********************************/

    protected function _setContainer()
    {
        $this->_container = Container::getInstance();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** SET REPOSITORY BUIDER **********/
    /*******************************************/

    abstract protected function _setRepositoryBuilder();

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE HANDLER **********/
    /************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    abstract protected function _createHandler($requestService): IHandler;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @param String $requestService object that manages requests (static class)
     * @return Mixed IHandler
     */

    public function create(string $requestService): IHandler
    {
        return $this->_createHandler($requestService);
    }
}