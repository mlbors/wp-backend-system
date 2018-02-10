<?php
/**
 * WP System - IStateFactory - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/************************************/
/********** ISTATE FACTORY **********/
/************************************/

interface IStateFactory
{
    public function create(string $state, IEntity $entity): IState;
}