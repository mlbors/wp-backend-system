<?php
/**
 * WP System - IChainHandler - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/************************************/
/********** ICHAIN HANDLER **********/
/************************************/

interface IChainHandler
{
    public function canHandleRequest(IRequest $request): bool;
}