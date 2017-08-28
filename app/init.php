<?php
/**
 * WP Backend System - Init
 *
 * @since       31.07.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App;

use \App\Theme\Main as Main;

/********************************/
/********** INIT THEME **********/
/********************************/

add_action('after_setup_theme', function() {
    global $main;
    $main = Main::init();
});

/*********************************************************************************/
/*********************************************************************************/

/********************************/
/********** AFTER INIT **********/
/********************************/

add_action('wp', function(){
    global $main;
    global $settings;
    $main->retrieveSettings();
    $settings = $main->getSettings();
});