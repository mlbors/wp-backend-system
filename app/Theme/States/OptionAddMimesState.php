<?php
/**
 * WP System - OptionAddMimesState - Concrete Class
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

/********************************************/
/********** OPTION ADD MIMES STATE **********/
/********************************************/

class OptionAddMimesState extends AbstractOptionState
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
        $entity = $this->_entity;
        add_filter('upload_mimes', function($mimes) use ($entity) {
            $prefix = 'add_mimes_';
            if (is_array($entity)) {
                foreach ($entity as $i => $item) {
                    $mimes[$item['extenson']] = $item['type'];
                }
            }
            return $mimes;
        });
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_applyOption();
    }
}