<?php
/**
 * WP System - IGenerator - Interface
 *
 * @since       12.01.2018
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