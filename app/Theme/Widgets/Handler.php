<?php
/**
 * WP Backend System - Handler - Interface
 *
 * @since       16.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Widgets;

/*****************************/
/********** HANDLER **********/
/*****************************/

interface Handler
{
    public function setWidgetRegister(WidgetRegister $widgetRegister);
    public function getWidgetRegister(): WidgetRegister;
}