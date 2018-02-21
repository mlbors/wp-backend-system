<?php
/**
 * WP System - WidgetEntity - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Entities;

use App\Theme\Abstracts\AbstractEntity as AbstractEntity;

/***********************************/
/********** WIDGET ENTITY **********/
/***********************************/

class WidgetEntity extends AbstractEntity
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param Mixed $data entity properties
     */

    public function __construct($data)
    {
        parent::__construct($data);
    }
}