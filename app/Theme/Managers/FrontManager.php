<?php
/**
 * WP Backend System - Back End
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Managers;

use \App\Theme\Themes\Builder as Builder;
use \App\Theme\Options\OptionsHandler as OptionsHandler;
use \App\Theme\Posts\PostHandler as PostHandler;
use \App\Theme\Redirections\RedirectionsHandler as RedirectionsHandler;
use \App\Theme\Shortcodes\ShortcodeHandler as ShortcodeHandler;
use \App\Theme\Taxonomies\TaxonomyHandler as TaxonomyHandler;
use \App\Theme\Themes\Theme as Theme;
use \App\Theme\Themes\ThemeBuilder as ThemeBuilder;
use \App\Theme\Transients\TransientHandler as TransientHandler;
use \App\Theme\Users\UserHandler as UserHandler;
use \App\Theme\Widgets\WidgetHandler as WidgetHandler;

/******************************/
/********** BACK END **********/
/******************************/

class FrontManager implements Manager
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var ThemeBuilder $_themeBuilder object that builds theme
     * @var Theme $_theme builded theme
     * @var PostHander $_postHandler object that handles posts
     * @var TaxonomyHandler $_taxonomyHandler object that handles taxonomies
     * @var RedirectionsHandler $_redirectionsHandler object that handles redirections
     * @var UserHandler $_userHandler object that handles users
     * @var OptionsHandler $_optionsHandler object that handles options
     * @var TransientHandler $_transientHandler object that handles transients
     * @var WidgetHandler $_widgetHandler object thant handles widgets
     * @var ShortcodeHandler $_shortcodeHandler object that handles shortcodes
     */

    private $_themeBuilder;
    private $_theme;
    private $_postHandler;
    private $_taxonomyHandler;
    private $_redirectionsHandler;
    private $_userHandler;
    private $_optionsHandler;
    private $_transientHandler;
    private $_widgetHandler;
    private $_shortcodeHandler;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param ManagerBuilder $managerBuilder manager builder
     */

    public function __construct(ManagerBuilder $managerBuilder)
    {
        $this->_setValues($managerBuilder);
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    /*
     * @param ManagerBuilder $managerBuilder manager builder
     */

    private function _setValues(ManagerBuilder $managerBuilder)
    {
        $this->setPostHandler($managerBuilder->getPostHandler());
        $this->setTaxonomyHandler($managerBuilder->getTaxonomyHandler());
        $this->setRedirectionsHandler($managerBuilder->getRedirectionsHandler());
        $this->setUserHandler($managerBuilder->getUserHandler());
        $this->setOptionsHandler($managerBuilder->getOptionsHandler());
        $this->setTransientHandler($managerBuilder->getTransientHandler());
        $this->setWidgetHandler($managerBuilder->getWidgetHandler());
        $this->_setShortcodeHandler($managerBuilder->getShortcodeHandler());
        $this->_setThemeBuilder();
    }

    /**********/
    /********** THEME BUILDER **********/
    /**********/

    private function _setThemeBuilder()
    {
        $this->_themeBuilder = new ThemeBuilder($this->_postHandler->getPostGetter());
    }

    /**********/
    /********** THEME **********/
    /**********/

    /*
     * @param Object $theme theme to set
     */

    private function _setTheme(Theme $theme)
    {
        $this->_theme = $theme;
    }

    /**********/
    /********** SHORTCODE HANDLER **********/
    /**********/

    /*
     * @param ShortcodeHandler $_shortcodeHandler object that handles shortcodes
     */

    private function _setShortcodeHandler(ShortcodeHandler $shortcodeHandler)
    {
        $this->_shortcodeHandler = $shortcodeHandler;
    }

    /**********/
    /********** POST HANDLER **********/
    /**********/

    /*
     * @param PostHander $postHandler post handler to use
     */

    public function setPostHandler(PostHandler $postHandler)
    {
        $this->_postHandler = $postHandler;
    }

    /**********/
    /********** TAXONOMY HANDLER **********/
    /**********/

    /*
     * @param TaxonomyHandler $taxonomyHandler post handler to use
     */

    public function setTaxonomyHandler(TaxonomyHandler $taxonomyHandler)
    {
        $this->_taxonomyHandler = $taxonomyHandler;
    }

    /**********/
    /********** REDIRECTIONS HANDLER **********/
    /**********/

    /*
     * @param RedirectionsHandler $redirectionsHandler object that handles redirections
     */

    public function setRedirectionsHandler(RedirectionsHandler $redirectionsHandler)
    {
        $this->_redirectionsHandler = $redirectionsHandler;
    }

    /**********/
    /********** USER HANDLER **********/
    /**********/

    /*
     * @param UserHandler $_userHandler object that handles users
     */

    public function setUserHandler(UserHandler $userHandler)
    {
        $this->_userHandler = $userHandler;
    }

    /**********/
    /********** OPTIONS HANDLER **********/
    /**********/

    /*
     * @param OptionsHandler $optionsHandler object that handles options
     */

    public function setOptionsHandler(OptionsHandler $optionsHandler)
    {
        $this->_optionsHandler = $optionsHandler;
    }

    /**********/
    /********** TRANSIENT HANDLER **********/
    /**********/

    /*
     * @param TransientHandler $transientHandler object that handles transients
     */

    public function setTransientHandler(TransientHandler $transientHandler)
    {
        $this->_transientHandler = $transientHandler;
    }

    /**********/
    /********** WIDGET HANDLER **********/
    /**********/

    /*
     * @param WidgetHandler $widgetHandler object thant handles widgets
     */

    public function setWidgetHandler(WidgetHandler $widgetHandler)
    {
        $this->_widgetHandler = $widgetHandler;
    }
  
    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** THEME **********/
    /**********/

    /*
     * @return Theme
     */

    public function getTheme(): Theme
    {
        return $this->_theme;
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

    /**********/
    /********** POST HANDLER **********/
    /**********/

    /*
     * @return PostHander
     */

    public function getPostHandler(): PostHandler
    {
        return $this->_postHandler;
    }

    /**********/
    /********** TAXONOMY HANDLER **********/
    /**********/

    /*
     * @return TaxonomyHander
     */

    public function getTaxonomyHandler(): TaxonomyHandler
    {
        return $this->_taxonomyHandler;
    }

    /**********/
    /********** REDIRECTIONS HANDLER **********/
    /**********/

    /*
     * @return RedirectionsHander
     */

    public function getRedirectionsHandler(): RedirectionsHandler
    {
        return $this->_redirectionsHandler;
    }

    /**********/
    /********** USER HANDLER **********/
    /**********/

    /*
     * @return UserHander
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

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** SET REDIRECTIONS **********/
    /**************************************/

    private function _setUpRedirections()
    {
        $this->_redirectionsHandler->setUpRedirections();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET USER ROLES **********/
    /************************************/

    private function _setUpUserRoles()
    {
        $this->_userHandler->setUpUserRoles();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SET CPT **********/
    /*****************************/

    private function _setUpCPT()
    {
        $this->_postHandler->setCPT();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** SET CUSTOM TAXONOMIES **********/
    /*******************************************/

    private function _setUpCustomTaxonomies()
    {
        $this->_taxonomyHandler->setCustomTaxonomies();
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** BUILD THEME **********/
    /*********************************/

    private function _buildTheme()
    {
        $this->_setTheme($this->_themeBuilder->build());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** CREATE SHORTCODES **********/
    /***************************************/

    private function _createShortcodes()
    {
        $this->_shortcodeHandler->createShortcodes();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET UP WIDGETS **********/
    /************************************/

    private function _setUpWidgets()
    {
        $this->_widgetHandler->setUpWidgets();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET UP OPTIONS **********/
    /************************************/

    private function _setUpOptions()
    {
        $this->_optionsHandler->setUpOptions();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        try {
            $this->_setUpUserRoles();
            $this->_setUpRedirections();
            $this->_setUpCPT();
            $this->_setUpCustomTaxonomies();
            $this->_buildTheme();
            $this->_createShortcodes();
            $this->_setUpWidgets();
            $this->_setUpOptions();
        } catch (\Exception $e) {
            return false;
        }
    }

}