<?php
/**
 * WP System - IPageBuilder - Interface
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container; 

namespace App\Theme\Interfaces;

/***********************************/
/********** IPAGE BUILDER **********/
/***********************************/

interface IPageBuilder
{
    public function setRows(array $rows);
    public function build();
}