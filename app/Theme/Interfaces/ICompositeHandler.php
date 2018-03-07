<?php
/**
 * WP System - ICompisteHandler - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/****************************************/
/********** ICOMPOSITE HANDLER **********/
/****************************************/

interface ICompositeHandler
{
    public function addElement(IHandler $handler);
}