<?php
/**
 * WP System - IEntityFactory - Interface
 *
 * @since       2018.01.12
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