<?php
/**
 * WP System - RedirectionAdminState - Concrete Class
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

/*********************************************/
/********** REDIRECTION ADMIN STATE **********/
/*********************************************/

class RedirectionAdminState extends AbstractRedirectionState
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
        add_action('admin_init', function() use ($class) {
            if (!current_user_can('delete_posts') && strpos($_SERVER['PHP_SELF'], 'wp-admin/admin-ajax.php') === false) {
                $class->_executeRedirection();
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