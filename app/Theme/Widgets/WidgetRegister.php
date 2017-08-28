<?php
/**
 * WP Backend System - Widget Register - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Widgets;

/*************************************/
/********** WIDGET REGISTER **********/
/*************************************/

interface WidgetRegister
{
    public function registerWidget(string $name);
    public function setUpWidgets();
}