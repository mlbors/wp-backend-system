<?php
/**
 * WP System - BackManagerBuilder - Concrete Class
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
use App\Theme\Factories\CPTHandlerFactory as CPTHandlerFactory;
use App\Theme\Factories\CTHandlerFactory as CTHandlerFactory;
use App\Theme\Factories\OptionsHandlerFactory as OptionsHandlerFactory;
use App\Theme\Factories\PostsHandlerFactory as PostsHandlerFactory;
use App\Theme\Factories\TaxonomiesHandlerFactory as TaxonomiesHandlerFactory;
use App\Theme\Factories\UsersHandlerFactory as UsersHandlerFactory;
use App\Theme\Factories\UserRolesHandlerFactory as UserRolesHandlerFactory;
use App\Theme\Factories\BackViewControllerFactory as BackViewControllerFactory;
use App\Theme\Managers\BackManager as BackManager;

/******************************************/
/********** BACK MANAGER BUILDER **********/
/******************************************/

class BackManagerBuilder extends AbstractManagerBuilder
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IViewControllerFactory $_viewControllerFactory object that creates view controllers
     */

    protected $_viewControllerFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
        $this->_setViewControllerFactory();
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
            $this->_container->make(OptionsHandlerFactory::class)
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

    /*************************************************/
    /********** SET VIEW CONTROLLER FACTORY **********/
    /*************************************************/

    protected function _setViewControllerFactory()
    {
        $this->_viewControllerFactory = $this->_container->make(BackViewControllerFactory::class);
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
        return $this->_container->makeWith(BackManager::class, ['handlerFactories' => $this->_handlerFactories, 'requestServiceBuilder' => $this->_requestServiceBuilder, 'viewControllerFactory' => $this->_viewControllerFactory]);
    }
}