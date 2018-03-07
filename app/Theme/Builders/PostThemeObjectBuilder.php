<?php
/**
 * WP System - PostThemeObjectBuilder - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IThemeObject as IThemeObject;
use App\Theme\Interfaces\IPageBuilderFactory as IPageBuilderFactory;
use App\Theme\Abstracts\AbstractThemeObjectBuilder as AbstractThemeObjectBuilder;
use App\Theme\Factories\PageBuilderFactory as PageBuilderFactory;
use App\Theme\ThemeObjects\PostThemeObject as PostThemeObject;

/***********************************************/
/********** POST THEME OBJECT BUILDER **********/
/***********************************************/

class PostThemeObjectBuilder extends AbstractThemeObjectBuilder
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IPageBuilderFactory $_pageBuilderFactory object that creates page builders
     */

    protected $_pageBuilderFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
        $this->_setPageBuilderFactory();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** SET PAGE BUILDER FACTORY **********/
    /**********************************************/

    protected function _setPageBuilderFactory()
    {
        $this->_pageBuilderFactory = $this->_container->make(PageBuilderFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** CREATE THEME OBJECT **********/
    /*****************************************/

    /**
     * @param IEntity $entity entity object
     * @return IThemeObject
     */

    protected function _createThemeObject(IEntity $entity): IThemeObject
    {
        return $this->_container->makeWith(PostThemeObject::class, ['entity' => $entity, 'pageBuilderFactory' => $this->_pageBuilderFactory]);
    }
}