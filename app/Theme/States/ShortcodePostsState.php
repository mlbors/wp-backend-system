<?php
/**
 * WP System - ShortcodePostsState - Concrete Class
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

/*******************************************/
/********** SHORTCODE POSTS STATE **********/
/*******************************************/

class ShortcodePostsState extends AbstractShortcodeState
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

        if (!empty($this->_data['order']) && $this->_data['order'] !== 'none') {
            $args['order'] = $this->_data['order'];
            $args['orderby'] = $this->_data['orderby'];
        }

        if (!empty($this->_data['meta_key'])) {
            $args['meta_key'] = $this->_data['meta_key'];
        }

        if ($this->_data['tax_query_bool']) {
            $args['tax_query'] = [];
            $args['tax_query']['relation'] = $this->_data['tax_query_relation'];
            
            foreach($this->_data['tax_query_param'] as $p => $param) {
                $array = [];

                $terms = explode(",", $param['tax_query_param_terms']);

                $array['taxonomy'] = (string)$param['tax_query_param_tax'];
                $array['field'] = (string)$param['tax_query_param_field'];
                $array['terms'] = $terms;
                $array['operator'] = (string)(string)$param['tax_query_param_operator'];

                array_push($args['tax_query'], $array);
            }
        }

        if ($this->_data['meta_query_bool']) {
            $args['meta_query'] = [];
            $args['meta_query']['relation'] = $this->_data['meta_query_relation'];
            
            foreach($this->_data['meta_query_param'] as $p => $param) {
                $array = [];

                $value = explode(",", $param['meta_query_value']);

                if ($param['meta_query_compare'] !== 'IN' && $param['meta_query_compare'] !== 'NOT IN' && $param['meta_query_compare'] !== 'BETWEEN' && $param['meta_query_compare'] !== 'NOT BETWEEN') {
                    $value = $value[0];
                }

                $array['key'] = (string)$param['meta_query_param_key'];
                $array['value'] = $value;
                $array['compare'] = $param['meta_query_compare'];
                $array['type'] = (string)(string)$param['meta_query_type'];

                array_push($args['meta_query'], $array);
            }
        }

        if (!empty($this->_data['post_status'])) {
            if (count($this->_data['post_status']) > 1) {
                $args['post_status'] = $this->_data['post_status']; 
            } else {
                $args['post_status'] = $this->_data['post_status'][0]; 
            }
        } elseif(empty($this->_data['post_status'])) {
            $args['post_status'] = 'publish';
        }

        if (!empty($this->_data['limit'])) {
            $args['posts_per_page'] = $this->_data['limit'];
        } elseif(empty($this->_data['limit'])) {
            $args['posts_per_page'] = -1;
        }

        if (!empty($this->_data['includes'])) {
            $args['includes'] = $this->_data['includes'];
        }

        if (!empty($this->_data['supress_filters'])) {
            $args['supress_filters'] = $this->_data['supress_filters'];
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
            $posts = $this->_requestService::buildRequestAndExecute([
                'type' => 'post', 
                'action' => 'query'
                ], 
                [
                'method' => '', 
                'method_args' => ['method' => '', 'use_theme_object' => $this->_data['use_theme_objects']], 
                'query_args' => ['args' => $args]
                ]);

            if ($this->_data['use_theme_objects']) {
                $this->_setResult($posts);
                return $this->_result;
            }

            $this->_setResult($posts->getData());
            return $this->_result;

            

        } catch (\Exception $e) {
            return $this->_result;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_setData($this->_entity->post_lists);
        $this->_registerShortcode();
    }
}