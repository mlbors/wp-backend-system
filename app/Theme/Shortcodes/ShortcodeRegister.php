<?php
/**
 * WP Backend System - Shortcode Register - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Shortcodes;

/****************************************/
/********** SHORTCODE REGISTER **********/
/****************************************/

interface ShortcodeRegister
{
    public function registerShortcode(string $name, array $data);
}