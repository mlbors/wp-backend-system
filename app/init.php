<?php
/**
 * WP System - Theme
 *
 * @since       31.07.2017
 * @version     2.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App;

use Roots\Sage\Container;

use \App\Theme\Theme as Theme;

/********************************/
/********** INIT THEME **********/
/********************************/

add_action('after_setup_theme', function() {
    try {
        sage()->singleton('sage.theme', function() {
            return new Theme();
        });
    
        $container = Container::getInstance();
        $theme = $container->make(Theme::class);
        $theme->init();
        $theme->setGlobalSettings();
    } catch (\Exception $e) {
        return false;
    }
});

/*********************************************************************************/
/*********************************************************************************/