<?php
/**
 * WP System - AbstractStateFactory - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Interfaces\IStateFactory as IStateFactory;

/********************************************/
/********** ABSTRACT STATE FACTORY **********/
/********************************************/

abstract class AbstractStateFactory implements IStateFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Container $_container App container
     */

    protected $_container;

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

    /**********************************/
    /********** CREATE STATE **********/
    /**********************************/

    /**
     * @param String $state targeted $state
     * @param IEntity $entity redirection entity
     * @return IState
     */

    abstract protected function _createState(string $state, IEntity $entity): IState;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /**
     * @param String $state targeted $state
     * @param IEntity $entity redirection entity
     * @return Mixed IState
     */

    public function create(string $state, IEntity $entity): IState
    {
        return $this->_createState($state, $entity);
    }
}