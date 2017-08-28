<?php
/**
 * WP Backend System - Widget Handler Factory
 *
 * @since       16.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Widgets;

use App\Theme\Posts\PostGetter as PostGetter;

/********************************************/
/********** WIDGET HANDLER FACTORY **********/
/********************************************/

class WidgetHandlerFactory implements HandlerFactory
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** CREATE **********/
    /****************************/

    /*
     * @param PostGetter $postGetter object that gets posts
     * @return Handler
     */

    public function create(PostGetter $postGetter): Handler
    {
        return new WidgetHandler(new MainWidgetRegister($postGetter));
    }

    /*********************************************************************************/
    /*********************************************************************************/

}