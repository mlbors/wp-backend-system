<?php
/**
 * WP System - ShortcodesRepository - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Repositories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraints as IConstraints;
use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IContextFactory as IContextFactory;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IThemeObject as IThemeObject;
use App\Theme\Interfaces\IThemeObjectBuilder as IThemeObjectBuilder;
use App\Theme\Abstracts\AbstractRepository as AbstractRepository;

/*******************************************/
/********** SHORTCODES REPOSITORY **********/
/*******************************************/

class ShortcodesRepository extends AbstractRepository
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IContextFactory $contextFactory object that creates data context
     * @param IThemeObjectBuilder $themeObjectBuilder object that build theme object
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IContextFactory $contextFactory, IThemeObjectBuilder $themeObjectBuilder, string $requestService)
    {
        parent::__construct($contextFactory, $themeObjectBuilder, $requestService, 'shortcode');
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** REGISTER **********/
    /******************************/

    /**
     * @param IConstraints $constraints constraints for query
     */

    public function register(IConstraints $constraints)
    {
        $action = 'register' . ucfirst($this->_type) . $constraints->args['method'];
        return $this->_executeQuery($action, $constraints);
    }
}