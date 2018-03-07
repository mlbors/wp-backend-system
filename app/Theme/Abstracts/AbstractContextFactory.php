<?php
/**
 * WP System - AbstractContextFactory - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IContextFactory as IContextFactory;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;

/**********************************************/
/********** ABSTRACT CONTEXT FACTORY **********/
/**********************************************/

abstract class AbstractContextFactory implements IContextFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var IEntityFactory $_entityFactory object that creates entities
     */

    protected $_container;
    protected $_entityFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntityFactory $entityFactory object that creates entities
     */

    public function __construct(IEntityFactory $entityFactory)
    {
        $this->_setValues($entityFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IEntityFactory $entityFactory object that creates entities
     */

    protected function _setValues(IEntityFactory $entityFactory)
    {
        $this->_setContainer();
        $this->_setEntityFactory($entityFactory);
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

    /****************************************/
    /********** SET ENTITY FACTORY **********/
    /****************************************/

    /**
     * @param IEntityFactory $entityFactory object that creates entities
     */

    protected function _setEntityFactory(IEntityFactory $entityFactory)
    {
        $this->_entityFactory = $entityFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE CONTEXT **********/
    /************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     * @return IContext
     */

    abstract protected function _createContext(string $requestService): IContext;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @param String $requestService object that manages requests (static class)
     * @return Mixed IContext
     */

    public function create(string $requestService): IContext
    {
        return $this->_createContext($requestService);
    }
}