<?php
/**
 * WP System - CSSGeneratorFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IGenerator as IGenerator;
use App\Theme\Abstracts\AbstractGeneratorFactory as AbstractGeneratorFactory;
use App\Theme\Generators\CSSGenerator as CSSGenerator;

/*******************************************/
/********** CSS GENERATOR FACTORY **********/
/*******************************************/

class CSSGeneratorFactory extends AbstractGeneratorFactory
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** CREATE GENERATOR **********/
    /**************************************/

    /**
     * @return IGenerator
     */

    protected function _createGenerator(): IGenerator
    {
        return $this->_container->make(CSSGenerator::class);
    }
}