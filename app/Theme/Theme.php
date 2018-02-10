<?php
/**
 * WP System - Theme
 *
 * @since       31.07.2017
 * @version     2.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme;

use Roots\Sage\Container;

use \App\Theme\Abstracts\AbstractTheme as AbstractTheme;
use \App\Theme\Factories\MainInitializerFactory as MainInitializerFactory;

/***************************/
/********** THEME **********/
/***************************/

final class Theme extends AbstractTheme
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        $this->_setValues();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    private function _setValues()
    {
        $container = Container::getInstance();
        $this->_setInitializerFactory($container->make(MainInitializerFactory::class));
        $this->_setInitializer($this->_initializerFactory->create());
    }
}