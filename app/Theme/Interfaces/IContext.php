<?php
/**
 * WP System - IContext - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/******************************/
/********** ICONTEXT **********/
/******************************/

interface IContext
{
    public function executeQuery(string $action, array $methodArgs, array $queryArgs);
    public function createEntity($data): IEntity;
}