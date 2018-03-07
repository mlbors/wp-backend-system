<?php
/**
 * WP System - AbstractConstraints - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraints as IConstraints;

/******************************************/
/********** ABSTRACT CONSTRAINTS **********/
/******************************************/

abstract class AbstractConstraints implements IConstraints
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Array $_args constraints arguments
     * @var Array $args public constraints arguments
     */

    protected $_args = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET ARGS **********/
    /******************************/

    /**
     * @param Array $args constraints arguments
     */

    protected function _setArgs(array $args)
    {
        $this->_args = $args;
        $this->_setPublicArgs();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** SET PUBLIC ARGS **********/
    /*************************************/

    protected function _setPublicArgs()
    {
        $this->args = $this->_args;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** SET **********/
    /*************************/

    /**
     * @param Array $args constraints arguments
     */

    public function set(array $args = [])
    {
        $this->_setArgs($args);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** GET **********/
    /*************************/

    /**
     * @return IConstraints
     */

    public function get(): IConstraints
    {
        return $this;
    }

}