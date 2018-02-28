<?php
/**
 * WP System - WPDBWidgetsContext - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Contexts;

use stdClass;
use WP_Query;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Abstracts\AbstractContext as AbstractContext;
use App\Theme\Helpers\ACFFieldsHelper as ACFFieldsHelper;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;
use App\Theme\Helpers\FilesHelper as FilesHelper;

/*******************************************/
/********** WP DB WIDGETS CONTEXT **********/
/*******************************************/

class WPDBWidgetsContext extends AbstractContext
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntityFactory $entityFactory object that create entities
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IEntityFactory $entityFactory, string $requestService)
    {
        parent::__construct($entityFactory, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** QUERY WIDGET **********/
    /**********************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */

    protected function _queryWidget($methodArgs, $queryArgs)
    {
        $result = [];
        $widgets = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-widgets', ['custom_widgets_']);

        if (ArraysHelper::checkArray($widgets)) {
            foreach($widgets as $v => $value) {
                array_push($result, (object)$value);
            }
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** REGISTER WIDGET **********/
    /*************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed Bool || WP Post Type || WP Error)
     */

    protected function _registerWidget($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs)) {
            return false;
        }

        $register = '';
        $filepath = '';
        $tokens = [];
        $hasClass = false;
        $hasClassName = false;
        $name = (string)$queryArgs[0]->name;

        $filepath = FilesHelper::checkIfFileExists($name . '.php', ['Widgets', 'Extends/Widgets']);
        $filetokens = FilesHelper::getFileTokens($filepath);

        if (!empty($filetokens)) {
            $tokens = $filetokens;
            $checkedTokens = FilesHelper::checkTokens($tokens, ['class', $name]);
            $hasClass = in_array('class', $checkedTokens) ? true : false;
            $hasClassName = in_array($name, $checkedTokens) ? true : false;
        }
        
        if ($hasClass && $hasClassName) {
            require_once($filepath);
            $register = add_action('widgets_init', function() use($name) {
                register_widget($name);
            });
        }

        return $register;
    }
}