<?php
/**
 * WP System - IEntityFactory - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/*************************************/
/********** IENTITY FACTORY **********/
/*************************************/

interface IEntityFactory
{
    public function create($data): IEntity;
}