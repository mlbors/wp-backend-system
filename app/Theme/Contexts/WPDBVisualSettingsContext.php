<?php
/**
 * WP System - WPDBVisualSettingsContext - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Contexts;

use WP_Query;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;
use App\Theme\Abstracts\AbstractContext as AbstractContext;
use App\Theme\Helpers\ACFFieldsHelper as ACFFieldsHelper;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;

/***************************************************/
/********** WP DB VISUAL SETTINGS CONTEXT **********/
/***************************************************/

class WPDBVisualSettingsContext extends AbstractContext
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

    /******************************************/
    /********** QUERY VISUAL SETTING **********/
    /******************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */

    protected function _queryVisual($methodArgs, $queryArgs)
    {
        $result = [];
        $settings = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-visual-settings', ['custom_visual_settings_']);

        if (ArraysHelper::checkArray($settings)) {
            foreach($settings as $s => $setting) {
                if (!empty($setting)) {
                    array_push($result, (object)['type' => $s, 'value' => $setting]);
                }
            }
        }

        return $result;
    }
}