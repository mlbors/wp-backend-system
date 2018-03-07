<?php
/**
 * WP System - AbstractRequest - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraints as IConstraints;
use App\Theme\Interfaces\IRequest as IRequest;

/**************************************/
/********** ABSTRACT REQUEST **********/
/**************************************/

abstract class AbstractRequest implements IRequest
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Array $_args request arguments
     * @var IConstraints $_constraints request constraints
     * @var Array $args public request arguments
     * @var IConstraints $constraints public request constraints
     */

    protected $_args = [];
    protected $_constraints = [];
    public $args = [];
    public $constraints = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET ARGS **********/
    /******************************/

    /**
     * @param Array $args request arguments
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

    /*************************************/
    /********** SET CONSTRAINTS **********/
    /*************************************/

    /**
     * @param IConstraints $constraints request constraints
     */

    protected function _setConstraints(IConstraints $constraints)
    {
        $this->_constraints = $constraints;
        $this->_setPublicConstraints();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** SET PUBLIC CONSTRAINTS **********/
    /********************************************/

    protected function _setPublicConstraints()
    {
        $this->constraints = $this->_constraints;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** SET **********/
    /*************************/

    /**
     * @param Array $args request arguments
     * @param IConstraints $constraints request constraints
     */

    public function set(array $args = [], IConstraints $constraints = null)
    {
        $this->_setArgs($args);
        $this->_setConstraints($constraints);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** GET **********/
    /*************************/

    /**
     * @return IRequest
     */

    public function get(): IRequest
    {
        return $this;
    }

}