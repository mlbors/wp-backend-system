<?php
/**
 * WP System - AbstractRepositoryBuilder - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Interfaces\IRepository as IRepository;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;

/*************************************************/
/********** ABSTRACT REPOSITORY BUILDER **********/
/*************************************************/

abstract class AbstractRepositoryBuilder implements IRepositoryBuilder
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     * @var IEntityFactory $_entityFactory object that creates entities
     * @var IContextFactory $_contextFactory object that creates contexts
     * @var IThemeObjectBuilder $_themeObjectBuilder object that builds theme objects
     */

    protected $_container;
    protected $_entityFactory;
    protected $_contextFactory;
    protected $_themeObjectBuilder;

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
        $this->_setEntityFactory();
        $this->_setContextFactory();
        $this->_setThemeObjectBuilder();
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

    abstract protected function _setEntityFactory();

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET CONTEXT FACTORY **********/
    /*****************************************/

    abstract protected function _setContextFactory();

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** SET THEME OBJECT BUILDER **********/
    /**********************************************/

    abstract protected function _setThemeObjectBuilder();

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** CREATE REPOSITORY **********/
    /***************************************/

    /**
     * @return IRepository
     */

    abstract protected function _createRepository(string $requestService): IRepository;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @return Mixed IRepository
     */

    public function create(string $requestService): IRepository
    {
        return $this->_createRepository($requestService);
    }
}