<?php
/**
 * WP System - IGeneratorFactory - Interface
 *
 * @since       12.01.2018
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