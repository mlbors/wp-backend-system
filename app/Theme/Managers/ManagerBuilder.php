<?php
/**
 * WP Backend System - Manager Builder - Interface
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Managers;

/*************************************/
/********** MANAGER BUILDER **********/
/*************************************/

interface ManagerBuilder
{
    public function createManager(): Manager;
}