<?php
/**
 * WP System - FrontManagerBuilder - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IManager as IManager;
use App\Theme\Interfaces\IRequestServiceBuilder as IRequestServiceBuilder;
use App\Theme\Abstracts\AbstractManagerBuilder as AbstractManagerBuilder;
use App\Theme\Builders\RequestServiceBuilder as RequestServiceBuilder;
use App\Theme\Factories\APISHandlerFactory as APISHandlerFactory;
use App\Theme\Factories\CPTHandlerFactory as CPTHandlerFactory;
use App\Theme\Factories\CTHandlerFactory as CTHandlerFactory;
use App\Theme\Factories\OptionsHandlerFactory as OptionsHandlerFactory;
use App\Theme\Factories\PostsHandlerFactory as PostsHandlerFactory;
use App\Theme\Factories\RedirectionsHandlerFactory as RedirectionsHandlerFactory;
use App\Theme\Factories\ShortcodesHandlerFactory as ShortcodesHandlerFactory;
use App\Theme\Factories\TaxonomiesHandlerFactory as TaxonomiesHandlerFactory;
use App\Theme\Factories\UsersHandlerFactory as UsersHandlerFactory;
use App\Theme\Factories\UserRolesHandlerFactory as UserRolesHandlerFactory;
use App\Theme\Factories\VisualSettingsHandlerFactory as VisualSettingsHandlerFactory;
use App\Theme\Factories\WidgetsHandlerFactory as WidgetsHandlerFactory;
use App\Theme\Managers\FrontManager as FrontManager;

/*******************************************/
/********** FRONT MANAGER BUILDER **********/
/*******************************************/

class FrontManagerBuilder extends AbstractManagerBuilder
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** SET HANDLER FACTORIES **********/
    /*******************************************/

    protected function _setHandlerFactories()
    {
        $this->_handlerFactories = [
            $this->_container->make(PostsHandlerFactory::class),
            $this->_container->make(TaxonomiesHandlerFactory::class),
            $this->_container->make(CPTHandlerFactory::class),
            $this->_container->make(CTHandlerFactory::class),
            $this->_container->make(UsersHandlerFactory::class),
            $this->_container->make(UserRolesHandlerFactory::class),
            $this->_container->make(RedirectionsHandlerFactory::class),
            $this->_container->make(OptionsHandlerFactory::class),
            $this->_container->make(VisualSettingsHandlerFactory::class),
            $this->_container->make(ShortcodesHandlerFactory::class),
            $this->_container->make(APISHandlerFactory::class),
            $this->_container->make(WidgetsHandlerFactory::class)
        ];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** SET REQUEST SERVICE BUILDER **********/
    /*************************************************/

    protected function _setRequestServiceBuilder()
    {
        $this->_requestServiceBuilder = $this->_container->make(RequestServiceBuilder::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE MANAGER **********/
    /************************************/

    /**
     * @return IManager
     */

    protected function _createManager(): IManager
    {
        return $this->_container->makeWith(FrontManager::class, ['handlerFactories' => $this->_handlerFactories, 'requestServiceBuilder' => $this->_requestServiceBuilder]);
    }
}