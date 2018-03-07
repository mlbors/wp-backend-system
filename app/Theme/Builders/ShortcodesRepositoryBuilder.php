<?php
/**
 * WP System - ShortcodesRepositoryBuilder- Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Builders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContextFactory as IContextFactory;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Interfaces\IRepository as IRepository;
use App\Theme\Interfaces\IThemeObjectBuilder as IThemeObjectBuilder;
use App\Theme\Abstracts\AbstractRepositoryBuilder as AbstractRepositoryBuilder;
use App\Theme\Factories\ShortcodeEntityFactory as ShortcodeEntityFactory;
use App\Theme\Factories\WPDBShortcodesContextFactory as WPDBShortcodesContextFactory;
use App\Theme\Builders\ShortcodeThemeObjectBuilder as ShortcodeThemeObjectBuilder;
use App\Theme\Repositories\ShortcodesRepository as ShortcodesRepository;
use App\Theme\ThemeObjects\ShortcodeThemeObject as ShortcodeThemeObject;

/***************************************************/
/********** SHORTCODES REPOSITORY BUILDER **********/
/***************************************************/

class ShortcodesRepositoryBuilder extends AbstractRepositoryBuilder
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

    /****************************************/
    /********** SET ENTITY FACTORY **********/
    /****************************************/

    protected function _setEntityFactory()
    {
        $this->_entityFactory = $this->_container->make(ShortcodeEntityFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET CONTEXT FACTORY **********/
    /*****************************************/

    protected function _setContextFactory()
    {
        $this->_contextFactory = $this->_container->makeWith(WPDBShortcodesContextFactory::class, ['entityFactory' => $this->_entityFactory]);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** SET THEME OBJECT BUILDER **********/
    /**********************************************/

    protected function _setThemeObjectBuilder()
    {
        $this->_themeObjectBuilder = $this->_container->make(ShortcodeThemeObjectBuilder::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** CREATE REPOSITORY **********/
    /***************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     * @return IRepository
     */

    protected function _createRepository(string $requestService): IRepository
    {
        $this->_themeObjectBuilder->prepareBuilder($requestService);
        return $this->_container->makeWith(ShortcodesRepository::class, ['contextFactory' => $this->_contextFactory, 'themeObjectBuilder' => $this->_themeObjectBuilder, 'requestService' => $requestService]);
    }
}