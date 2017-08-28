<?php
/**
 * WP Backend System - Handler - Interface
 *
 * @since       04.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Settings;

/*****************************/
/********** HANDLER **********/
/*****************************/

interface Handler
{
    public function getSettings(): array;
    public function generateSettingsPage();
    public function init();
}