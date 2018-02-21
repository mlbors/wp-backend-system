<?php
/**
 * WP System - ShortcodePostState - Concrete Class
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
use App\Theme\Abstracts\AbstractShortcodeState as AbstractShortcodeState;

/******************************************/
/********** SHORTCODE POST STATE **********/
/******************************************/

class ShortcodePostState extends AbstractShortcodeState
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

    /**********************************/
    /********** PREPARE ARGS **********/
    /**********************************/

    /**
     * @return Array
     */

    protected function _prepareArgs(): array
    {
        $args = [];
        $args['post_id'] = $this->_data['post'];

        if (!empty($this->_data['includes'])) {
            $args['includes'] = $this->_data['includes'];
        }

        return $args;
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
        try {

            $result = [];
            $args = $this->_prepareArgs();
            $post = $this->_requestService::buildRequestAndExecute([
                'type' => 'post', 
                'action' => 'query'
                ], 
                [
                'method' => 'ByID', 
                'method_args' => [], 
                'query_args' => ['args' => $args]
                ]);

            if ($this->_data['use_theme_objects']) {
                $this->_setResult($post);
                return $this->_result;
            }

            $this->_setResult($post->getData());
            return $this->_result;

        } catch (\Exception $e) {
            return $data;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_setData($this->_entity->display_post);
        $this->_registerShortcode();
    }
}