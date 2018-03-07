<?php
/**
 * WP System - APIEntityFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Abstracts\AbstractEntityFactory as AbstractEntityFactory;
use App\Theme\Entities\APIEntity as APIEntity;

/****************************************/
/********** API ENTITY FACTORY **********/
/****************************************/

class APIEntityFactory extends AbstractEntityFactory
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
        return $this->_container->makeWith(APIEntity::class, ['data' => $data]);
    }
}