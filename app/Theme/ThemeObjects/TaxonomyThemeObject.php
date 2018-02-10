<?php
/**
 * WP System - TaxonomyThemeObject - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\ThemeObjects;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Abstracts\AbstractThemeObject as AbstractThemeObject;

/*******************************************/
/********** TAXONOMY THEME OBJECT **********/
/*******************************************/

class TaxonomyThemeObject extends AbstractThemeObject
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     */

    public function __construct(IEntity $entity)
    {
        parent::__construct($entity);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** GET TERMS **********/
    /*******************************/

    /**
     * @param Array $args query arguments
     * @return Array
     */

    public function getTerms(array $args = [])
    {
        if (empty($this->_entity->name)) {
            return false;
        }

        return get_terms($this->_entity->name, $args);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET TERM BY SLUG **********/
    /**************************************/

    /**
     * @param String $slug term slug
     * @return Mixed Object || false
     */

    public function getTermBySlug(string $slug)
    {
        if (empty((string)$slug) || empty((string)$this->_entity->name)) {
            return false;
        }

        return get_term_by('slug', $slug, $this->_entity->name);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET TERM BY NAME **********/
    /**************************************/

    /**
     * @param String $name term name
     * @return Mixed Object || false
     */

    public function getTermByName(string $name)
    {
        if (empty((string)$name) || empty((string)$this->_entity->name))  {
            return false;
        }

        return get_term_by('name', $name, $this->_entity->name);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** GET TERM BY ID **********/
    /************************************/

    /**
     * @param Int $id term id
     * @return Mixed Object || false
     */

    public function getTermById(int $id)
    {
        if (empty((int)$name) || empty((string)$this->_entity->name))  {
            return false;
        }

        return get_term_by('id', $id, $this->_entity->name);
    }
}