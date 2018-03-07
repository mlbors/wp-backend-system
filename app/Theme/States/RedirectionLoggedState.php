<?php
/**
 * WP System - RedirectionLoggedState - Concrete Class
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

/**********************************************/
/********** REDIRECTION LOGGED STATE **********/
/**********************************************/

class RedirectionLoggedState extends AbstractRedirectionState
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
        $entity = $this->_entity;
        add_action('template_redirect', function() use ($class, $entity) {
            if (is_user_logged_in() && is_page_template($entity->template)) {
                $class->_executeRedirection($entity->target);
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