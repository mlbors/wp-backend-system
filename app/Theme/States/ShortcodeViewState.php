<?php
/**
 * WP System - ShortcodeViewState - Concrete Class
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
use App\Theme\Abstracts\AbstractShortcodeState as AbstractShortcodeState;

/******************************************/
/********** SHORTCODE VIEW STATE **********/
/******************************************/

class ShortcodeViewState extends AbstractShortcodeState
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     * @param String $transientService object that manages transients (static class)
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IEntity $entity, string $transientService, string $requestService)
    {
        parent::__construct($entity, $transientService, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** EXECUTE QUERY **********/
    /***********************************/

    /**
     * @param Array $data shortcode's data
     * @return Mixed
     */

    protected function _executeQuery()
    {
        $this->_setResult($this->_data);
        return $this->_result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_setData($this->_entity->display_view);
        $this->_registerShortcode();
    }
}