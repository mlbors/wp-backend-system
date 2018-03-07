<?php
/**
 * WP System - AbstractSide - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISide as ISide;
use App\Theme\Interfaces\IManager as IManager;
use App\Theme\Interfaces\IManagerBuilder as IManagerBuilder;

/***********************************/
/********** ABSTRACT SIDE **********/
/***********************************/

abstract class AbstractSide implements ISide
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Array $_managers array of managers
     * @var Array $_managerBuilders array of object that builds managers
     */

    protected $_managers = [];
    protected $_managerBuilders = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param Array $managerBuilders array of object that builds managers
     */

    public function __construct(array $managerBuilders)
    {
        $this->_setValues($managerBuilders);
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
    /********** INIT MANAGERS **********/
    /***********************************/

    public function initManagers()
    {
        foreach($this->_managers as $manager) {
            $manager->init();
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param Array $managerBuilders array of object that builds managers
     */

    protected function _setValues(array $managerBuilders)
    {
        $this->_setManagerBuilders($managerBuilders);
        $this->_instantiateManagers();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SET MANAGERS **********/
    /**********************************/

    /**
     * @param Array $managers array of managers
     */

    public function setManagers(array $managers)
    {
        $this->_managers = $managers;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** SET MANAGER BUILDERS **********/
    /******************************************/

    /**
     * @param array $managerBuilders array of object that builds managers
     */

    protected function _setManagerBuilders(array $managerBuilders)
    {
        $this->_managerBuilders = $managerBuilders;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET MANAGERS **********/
    /**********************************/

    /**
     * @return Array
     */

    public function getManagers(): array
    {
        return $this->_managers;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** GET MANAGER BUILDERS **********/
    /******************************************/

    /**
     * @return Array
     */

    public function getManagerBuilders(): array
    {
        return $this->_managerBuilders;
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
    /********** PUSH MANAGER **********/
    /**********************************/

    /**
     * @param IManager $manager manager object
     */

    protected function _pushManager(IManager $manager)
    {
        array_push($this->_managers, $manager);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** PUSH MANAGER BUILDER **********/
    /******************************************/

    /**
     * @param IManagerBuilder $managerBuilder object that creates handlers
     */

    protected function _pushManagerBuilder(IManagerBuilder $managerBuilder)
    {
        array_push($this->_managerBuilders, $managerBuilder);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** INSTANTIATE MANAGERS **********/
    /******************************************/

    protected function _instantiateManagers()
    {
        foreach($this->_managerBuilders as $builder) {
            $this->_pushManager($builder->create());
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** REGISTER BUILDER **********/
    /**************************************/

    /**
     * @param IManagerBuilder $managerBuilder object that creates handlers
     */

    protected function _registerManagerBuilder(IManagerBuilder $managerBuilder)
    {
        $this->_pushManagerBuilder($managerBuilder);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** REGISTER MANAGER **********/
    /**************************************/

    /**
     * @param IManagerBuilder $managerBuilder object that creates handlers
     */

    public function registerManager(IManagerBuilder $managerBuilder)
    {
        $this->_registerManagerBuilder($managerBuilder);
        $this->_pushManager($managerBuilder->create());
    }
}