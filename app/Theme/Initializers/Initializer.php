<?php
/**
 * WP Backend System - Initializer - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Initializers;

/*********************************/
/********** INITIALIZER **********/
/*********************************/

interface Initializer
{
    public function init(): bool;
}