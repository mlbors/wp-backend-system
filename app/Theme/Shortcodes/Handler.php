<?php
/**
 * WP Backend System - Handler - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Shortcodes;

/*****************************/
/********** HANDLER **********/
/*****************************/

interface Handler
{
    public function setShortcodeRegister(ShortcodeRegister $shortcodeRegister);
    public function getShortcodeRegister(): ShortcodeRegister;
}