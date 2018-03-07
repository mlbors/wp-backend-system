<?php
/**
 * WP System - ITheme - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container; 

namespace App\Theme\Interfaces;

/****************************/
/********** ITHEME **********/
/****************************/

interface ITheme
{
    public function init();
    public function setGlobalSettings();
    public function getSettings(): array;
}