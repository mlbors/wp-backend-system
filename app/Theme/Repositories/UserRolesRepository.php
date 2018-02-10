<?php
/**
 * WP System - UserRolesRepository - Abstract Class
 *
 * @since       12.01.2018
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
/********** USER ROLES REPOSITORY **********/
/*******************************************/

class UserRolesRepository extends AbstractRepository
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
        parent::__construct($contextFactory, $themeObjectBuilder, $requestService, 'role');
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