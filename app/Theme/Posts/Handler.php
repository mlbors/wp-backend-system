<?php
/**
 * WP Backend System - Handler - Interface
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Posts;

/*****************************/
/********** HANDLER **********/
/*****************************/

interface Handler
{
    public function setPostGetter(PostGetter $postGetter);
    public function setCustomPostCreator(PostCreator $customPostCreator);
    public function getPostGetter(): PostGetter;
    public function getPostCreator(): PostCreator;
}