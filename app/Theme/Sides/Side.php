<?php
/**
 * WP Backend System - Side - Interface
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Sides;

use \App\Theme\Managers\Manager as Manager;

/**************************/
/********** SIDE **********/
/**************************/

interface Side
{
    public function setManagerBuilder();
    public function setManager(Manager $manager);
    public function getManager(): Manager;
    public function generate();
}