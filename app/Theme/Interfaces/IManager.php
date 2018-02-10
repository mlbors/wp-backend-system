<?php
/**
 * WP System - IManager - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/******************************/
/********** IMANAGER **********/
/******************************/

interface IManager
{
    public function init();
    public function initHandlers();
    public function setHandlers(array $handlers);
    public function getHandlers(): array;
    public function getSettings(): array;
    public function dispatchRequest(IRequest $request);
}