<?php
/**
 * WP System - AbstractConstraintsFactory - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraints as IConstraints;
use App\Theme\Interfaces\IConstraintsFactory as IConstraintsFactory;

/**************************************************/
/********** ABSTRACT CONSTRAINTS FACTORY **********/
/**************************************************/

abstract class AbstractConstraintsFactory implements IConstraintsFactory
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

    /****************************************/
    /********** CREATE CONSTRAINTS **********/
    /****************************************/

    abstract protected function _createConstraints(): IConstraints;

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /*
     * @return Mixed IConstraints
     */

    public function create(): IConstraints
    {
        return $this->_createConstraints();
    }
}