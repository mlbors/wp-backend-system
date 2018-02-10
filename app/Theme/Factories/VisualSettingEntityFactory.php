<?php
/**
 * WP System - VisualSettingEntityFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Abstracts\AbstractEntityFactory as AbstractEntityFactory;
use App\Theme\Entities\VisualSettingEntity as VisualSettingEntity;

/***************************************************/
/********** VISUAL SETTING ENTITY FACTORY **********/
/***************************************************/

class VisualSettingEntityFactory extends AbstractEntityFactory
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

    /***********************************/
    /********** CREATE ENTITY **********/
    /***********************************/

    /**
     * @param Mixed $data entity properties
     * @return IEntity
     */

    protected function _createEntity($data): IEntity
    {
        return $this->_container->makeWith(VisualSettingEntity::class, ['data' => $data]);
    }
}