<?php
/**
 * WP System - PageBuilderFactory - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IPageBuilder as IPageBuilder;
use App\Theme\Interfaces\IPageBuilderFactory as IPageBuilderFactory;
use App\Theme\Interfaces\IViewControllerFactory as IViewControllerFactory;
use App\Theme\Abstracts\AbstractPageBuilderFactory as AbstractPageBuilderFactory;
use App\Theme\PageBuilders\PageBuilder as PageBuilder;

/******************************************/
/********** PAGE BUILDER FACTORY **********/
/******************************************/

class PageBuilderFactory extends AbstractPageBuilderFactory
{
    /*************************************************/
    /********** SET VIEW CONTROLLER FACTORY **********/
    /*************************************************/

    protected function _setViewControllerFactory()
    {
        $this->_viewControllerFactory = $this->_container->make(PostPageBuilderViewControllerFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** CREATE PAGE BUILDER **********/
    /*****************************************/

    /**
     * @return IPageBuilder
     */

    protected function _createPageBuilder(): IPageBuilder
    {
        return $this->_container->makeWith(PageBuilder::class, ['viewControllerFactory' => $this->_viewControllerFactory]);
    }
}