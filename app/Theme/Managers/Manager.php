<?php
/**
 * WP Backend System - Manager - Interface
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Managers;

use \App\Theme\Options\OptionsHandler as OptionsHandler;
use \App\Theme\Posts\PostHandler as PostHandler;
use \App\Theme\Redirections\RedirectionsHandler as RedirectionsHandler;
use \App\Theme\Taxonomies\TaxonomyHandler as TaxonomyHandler;
use \App\Theme\Transients\TransientHandler as TransientHandler;
use \App\Theme\Users\UserHandler as UserHandler;
use \App\Theme\Widgets\WidgetHandler as WidgetHandler;

/*****************************/
/********** MANAGER **********/
/*****************************/

interface Manager
{
    public function setPostHandler(PostHandler $postHandler);
    public function setTaxonomyHandler(TaxonomyHandler $taxonomyHandler);
    public function setRedirectionsHandler(RedirectionsHandler $redirectionsHandler);
    public function setUserHandler(UserHandler $userHandler);
    public function setOptionsHandler(OptionsHandler $optionsHandler);
    public function setTransientHandler(TransientHandler $transientHandler);
    public function setWidgetHandler(WidgetHandler $widgetHandler);
    public function getPostHandler(): PostHandler;
    public function getTaxonomyHandler(): TaxonomyHandler;
    public function getRedirectionsHandler(): RedirectionsHandler;
    public function getUserHandler(): UserHandler;
    public function getOptionsHandler(): OptionsHandler;
    public function getTransientHandler(): TransientHandler;
    public function getWidgetHandler(): WidgetHandler;
    public function init();
}