<?php
/**
 * WP System - ISide - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/***************************/
/********** ISIDE **********/
/***************************/

interface ISide
{
    public function init();
    public function initManagers();
    public function setManagers(array $managers);
    public function getManagers(): array;
    public function getSettings(): array;
}