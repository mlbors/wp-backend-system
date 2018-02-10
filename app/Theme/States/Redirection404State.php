<?php
/**
 * WP System - Redirection404State - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\States;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractRedirectionState as AbstractRedirectionState;

/*******************************************/
/********** REDIRECTION 404 STATE **********/
/*******************************************/

class Redirection404State extends AbstractRedirectionState
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
        echo $target;
        add_action('template_redirect', function() use ($class, $target) {
            if (is_404()) {
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