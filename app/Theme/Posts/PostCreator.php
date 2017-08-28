<?php
/**
 * WP Backend System - Post Creator - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Posts;

/**********************************/
/********** POST CREATOR **********/
/**********************************/

interface PostCreator
{
    public function setArgs(array $args);
    public function setFormatedName(string $formatedName);
    public function registerPostType();
}