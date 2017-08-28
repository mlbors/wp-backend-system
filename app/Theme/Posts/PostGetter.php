<?php
/**
 * WP Backend System - Post Getter - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Posts;

/*********************************/
/********** POST GETTER **********/
/*********************************/

interface PostGetter
{
    public function setArgs(array $args);
    public function queryPost(String $method = null);
    public function getPostById();
}