<?php
/**
 * WP System - IGenerator - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/********************************/
/********** IGENERATOR **********/
/********************************/

interface IGenerator
{
    public function setData($data);
    public function getData();
    public function generate();
}