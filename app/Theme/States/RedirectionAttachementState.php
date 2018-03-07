<?php
/**
 * WP System - RedirectionAttachementState - Concrete Class
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
use App\Theme\Abstracts\AbstractRedirectionState as AbstractRedirectionState;

/***************************************************/
/********** REDIRECTION ATTACHEMENT STATE **********/
/***************************************************/

class RedirectionAttachementState extends AbstractRedirectionState
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

    /******************************/
    /********** REDIRECT **********/
    /******************************/

    protected function _redirect()
    {
        $class = $this;
        $target = $this->_entity->target;
        add_action('template_redirect', function() use ($class, $target) {
            if (is_attachment()) {
                $class->_executeRedirection($target);
            }
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_redirect();
    }
}