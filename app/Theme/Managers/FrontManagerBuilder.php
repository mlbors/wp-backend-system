<?php
/**
 * WP Backend System - Front Manager Builder
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Managers;

use \App\Theme\Options\OptionsHandlerFactory as OptionsHandlerFactory;
use \App\Theme\Posts\PostHandlerFactory as PostHandlerFactory;
use \App\Theme\Redirections\RedirectionsHandlerFactory as RedirectionsHandlerFactory;
use \App\Theme\Shortcodes\ShortcodeHandlerFactory as ShortcodeHandlerFactory;
use \App\Theme\Taxonomies\TaxonomyHandlerFactory as TaxonomyHandlerFactory;
use \App\Theme\Transients\TransientHandlerFactory as TransientHandlerFactory;
use \App\Theme\Users\UserHandlerFactory as UserHandlerFactory;
use \App\Theme\Widgets\WidgetHandlerFactory as WidgetHandlerFactory;

use \App\Theme\Options\OptionsHandler as OptionsHandler;
use \App\Theme\Posts\PostHandler as PostHandler;
use \App\Theme\Redirections\RedirectionsHandler as RedirectionsHandler;
use \App\Theme\Shortcodes\ShortcodeHandler as ShortcodeHandler;
use \App\Theme\Taxonomies\TaxonomyHandler as TaxonomyHandler;
use \App\Theme\Transients\TransientHandler as TransientHandler;
use \App\Theme\Users\UserHandler as UserHandler;
use \App\Theme\Widgets\WidgetHandler as WidgetHandler;

use \App\Theme\Posts\PostGetter as PostGetter;
use \App\Theme\Taxonomies\TaxonomyGetter as TaxonomyGetter;
use \App\Theme\Transients\TransientOperator as TransientOperator;

/****************************************/
/********** FRONT SIDE BUILDER **********/
/****************************************/

class FrontManagerBuilder implements ManagerBuilder
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var PostHander $_postHandler object that handles posts
     * @var PostGetter $_postGetter object that get posts
     * @var TaxonomyHandler $_taxonomyHandler object that handles taxonomies
     * @var TaxonomyGetter $_taxonomyGetter object that gets taxonomies
     * @var RedirectionsHandler $_redirectionsHandler object that handles redirections
     * @var UserHandler $_userHandler object that handles users
     * @var OptionsHandler $_optionsHandler object that handles options
     * @var TransientHandler $_transientHandler object that handles transients
     * @var TransientOperator $_transientOperator object that operates with transients
     * @var WidgetHandler $_widgetHandler object thant handles widgets
     * @var ShortcodeHandler $_shortcodeHandler object that handles shortcodes
     */

    private $_postHandler;
    private $_postGetter;
    private $_taxonomyHandler;
    private $_taxonomyGetter;
    private $_redirectionsHandler;
    private $_userHandler;
    private $_optionsHandler;
    private $_transientHandler;
    private $_transientOperator;
    private $_widgetHandler;
    private $_shortcodeHandler;
  

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

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    private function _setValues()
    {
        $this->_setPostHandler();
        $this->_setPostGetter();
        $this->_setTaxonomyHandler();
        $this->_setTaxonomyGetter();
        $this->_setRedirectionsHandler();
        $this->_setUserHandler();
        $this->_setOptionsHandler();
        $this->_setTransientHandler();
        $this->_setTransientOperator();
        $this->_setWidgetHandler();
        $this->_setShortcodeHandler();
    }

    /**********/
    /********** POST HANDLER **********/
    /**********/

    private function _setPostHandler()
    {
        $this->_postHandler = (new PostHandlerFactory())->create();
    }

    /**********/
    /********** POST GETTER **********/
    /**********/

    private function _setPostGetter()
    {
        $this->_postGetter = $this->_postHandler->getPostGetter();
    }

    /**********/
    /********** TAXONOMY HANDLER **********/
    /**********/

    private function _setTaxonomyHandler()
    {
        $this->_taxonomyHandler = (new TaxonomyHandlerFactory())->create();
    }

    /**********/
    /********** TAXONOMY GETTER **********/
    /**********/

    private function _setTaxonomyGetter()
    {
        $this->_taxonomyGetter = $this->_taxonomyHandler->getTaxonomyGetter();
    }

    /**********/
    /********** REDIRECTIONS HANDLER **********/
    /**********/

    private function _setRedirectionsHandler()
    {
        $this->_redirectionsHandler = (new RedirectionsHandlerFactory())->create($this->_postGetter);
    }

    /**********/
    /********** USER HANDLER **********/
    /**********/

    private function _setUserHandler()
    {
        $this->_userHandler = (new UserHandlerFactory())->create();
    }

    /**********/
    /********** OPTIONS HANDLER **********/
    /**********/

    private function _setOptionsHandler()
    {
        $this->_optionsHandler = (new OptionsHandlerFactory())->create($this->_postGetter);
    }

    /**********/
    /********** TRANSIENT HANDLER **********/
    /**********/

    private function _setTransientHandler()
    {
        $this->_transientHandler = (new TransientHandlerFactory())->create();
    }

    /**********/
    /********** TRANSIENT OPERATOR **********/
    /**********/

    private function _setTransientOperator()
    {
        $this->_transientOperator = $this->_transientHandler->getTransientOperator();
    }

    /**********/
    /********** WIDGET HANDLER **********/
    /**********/

    private function _setWidgetHandler()
    {
        $this->_widgetHandler = (new WidgetHandlerFactory())->create($this->_postGetter);
    }

    /**********/
    /********** SHORTCODE HANDLER **********/
    /**********/

    private function _setShortcodeHandler()
    {
        $this->_shortcodeHandler = (new ShortcodeHandlerFactory())->create($this->_postGetter, $this->_taxonomyGetter, $this->_transientOperator);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** POST HANDLER **********/
    /**********/

    /*
     * @return PostHandler
     */

    public function getPostHandler(): PostHandler
    {
        return $this->_postHandler;
    }

    /**********/
    /********** TAXONOMY HANDLER **********/
    /**********/

    /*
     * @return TaxonomyHandler
     */

    public function getTaxonomyHandler(): TaxonomyHandler
    {
        return $this->_taxonomyHandler;
    }

    /**********/
    /********** REDIRECTIONS HANDLER **********/
    /**********/

    /*
     * @return RedirectionsHandler
     */

    public function getRedirectionsHandler(): RedirectionsHandler
    {
        return $this->_redirectionsHandler;
    }

    /**********/
    /********** USER HANDLER **********/
    /**********/

    /*
     * @return UserHandler
     */

    public function getUserHandler(): UserHandler
    {
        return $this->_userHandler;
    }

    /**********/
    /********** OPTIONS HANDLER **********/
    /**********/

    /*
     * @return OptionsHandler
     */

    public function getOptionsHandler(): OptionsHandler
    {
        return $this->_optionsHandler;
    }

    /**********/
    /********** TRANSIENT HANDLER **********/
    /**********/

    /*
     * @return TransientHandler
     */

    public function getTransientHandler(): TransientHandler
    {
        return $this->_transientHandler;
    }

    /**********/
    /********** WIDGET HANDLER **********/
    /**********/

    /*
     * @return WidgetHandler
     */

    public function getWidgetHandler(): WidgetHandler
    {
        return $this->_widgetHandler;
    }

    /**********/
    /********** SHORTCODE HANDLER **********/
    /**********/

    /*
     * @return ShortcodeHandler
     */

    public function getShortcodeHandler(): ShortcodeHandler
    {
        return $this->_shortcodeHandler;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE MANAGER **********/
    /************************************/

    public function createManager(): Manager
    {
        $this->_setValues();
        return new FrontManager($this);
    }

}