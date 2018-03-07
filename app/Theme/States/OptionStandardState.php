<?php
/**
 * WP System - OptionStandardState - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\States;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractOptionState as AbstractOptionState;

/*******************************************/
/********** OPTION STANDARD STATE **********/
/*******************************************/

class OptionStandardState extends AbstractOptionState
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     */

    public function __construct(IEntity $entity)
    {
        parent::__construct($entity);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** APPLY OPTION **********/
    /**********************************/

    protected function _applyOption() 
    {
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
    }
}