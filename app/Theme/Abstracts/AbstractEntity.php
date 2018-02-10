<?php
/**
 * WP System - AbstractEntity - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;

/*************************************/
/********** ABSTRACT ENTITY **********/
/*************************************/

abstract class AbstractEntity implements IEntity
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Mixed $_data entity properties
     */

    protected $_data;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param Mixed $data entity properties
     */

    public function __construct($data)
    {
        $this->_setValues($data);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param Mixed $data entity properties
     */

    protected function _setValues($data)
    {
        $this->_setData($data);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET DATA **********/
    /******************************/

    /**
     * @param Mixed $data entity properties
     */

    protected function _setData($data)
    {
        $this->_data = $data;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** SET **********/
    /*************************/

    public function __set($property, $value)
    {
        if (is_array($this->_data)) {
            $this->_data[$property] = $value;
        } 

        $this->_data->{$property} = $value;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET DATA **********/
    /******************************/

    /**
     * @return Mixed
     */

    public function getData()
    {
        return $this->_data;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** GET **********/
    /*************************/

    /**
     * @return Mixed
     */

    public function __get($property)
    {
        if (is_array($this->_data)) {
            
            return array_key_exists($property, $this->_data) ? $this->_data[$property] : null;
        }
        return !empty($this->_data->{$property}) ? $this->_data->{$property} : null;
    }

}