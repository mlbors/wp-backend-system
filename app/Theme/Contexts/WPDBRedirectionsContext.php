<?php
/**
 * WP System - WPDBRedirectionsContext - Concrete Class
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

/************************************************/
/********** WP DB REDIRECITONS CONTEXT **********/
/************************************************/

class WPDBRedirectionsContext extends AbstractContext
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

    /***************************************/
    /********** QUERY REDIRECTION **********/
    /***************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Array
     */

    protected function _queryRedirection($methodArgs, $queryArgs)
    {
        $result = [];
        $redirections = ACFFieldsHelper::parseOptions($this->_requestService, 'acf-options-redirections', ['custom_redirections_redirections_', 'custom_redirections_']);

        foreach($redirections as $r => $redirection) {

            if ($r === 'redirection_subscribers_wp_admin' && $redirection) {
                array_push($result, (object)['template' => '', 'target' => '/', 'condition' => 'admin_redirect']);
            }

            if ($r === '404_redirection' && $redirections['redirect_404_bool']) {
                array_push($result, (object)['template' => '', 'target' => $redirection, 'condition' => '404_redirect']);
            }

            if ($r === 'attachements_redirection' && $redirections['redirect_attachements_bool']) {
                array_push($result, (object)['template' => '', 'target' => $redirection, 'condition' => 'attachement_redirect']);
            }

            if ($r === 'redirections' && is_array($redirection) && count(array_filter($redirection)) > 0) {
                foreach($redirection as $s => $sub) {
                    array_push($result, (object)$sub);
                }
            }   
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** APPLY REDIRECTION **********/
    /***************************************/

    /**
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return
     */

    protected function _applyRedirection($methodArgs, $queryArgs)
    {
        if (!$this->_checkQueryArgs($queryArgs, ['redirection'])) {
            return false;
        }

        $queryArgs['redirection']->apply();
        return;
    }
}