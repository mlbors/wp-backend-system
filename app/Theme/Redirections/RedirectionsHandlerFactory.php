<?php
/**
 * WP Backend System - Redirections Handler Factory
 *
 * @since       14.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Redirections;

use App\Theme\Posts\PostGetter as PostGetter;

/**************************************************/
/********** REDIRECTIONS HANDLER FACTORY **********/
/**************************************************/

class RedirectionsHandlerFactory implements HandlerFactory
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
        return new RedirectionsHandler($postGetter);
    }

    /*********************************************************************************/
    /*********************************************************************************/

}