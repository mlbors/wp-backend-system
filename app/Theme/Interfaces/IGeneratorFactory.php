<?php
/**
 * WP System - IGeneratorFactory - Interface
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

use Roots\Sage\Container;

namespace App\Theme\Interfaces;

/****************************************/
/********** IGENERATOR FACTORY **********/
/****************************************/

interface IGeneratorFactory
{
    public function create(): IGenerator;
}