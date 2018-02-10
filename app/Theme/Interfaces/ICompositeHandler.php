<?php
/**
 * WP System - ICompisteHandler - Interface
 *
 * @since       12.01.2018
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