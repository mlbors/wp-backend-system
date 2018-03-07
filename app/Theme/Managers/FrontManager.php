<?php
/**
 * WP System - FrontManager - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Managers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IRequestServiceBuilder as IRequestServiceBuilder;
use App\Theme\Interfaces\ITransientServiceBuilder as ITransientServiceBuilder;
use App\Theme\Abstracts\AbstractManager as AbstractManager;

/***********************************/
/********** FRONT MANAGER **********/
/***********************************/

class FrontManager extends AbstractManager
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param Array $handlersFactories array object that creates handlers
     * @param IRequestServiceBuilder $requestServiceBuilder object that creates request services
     */

    public function __construct(array $handlerFactories, IRequestServiceBuilder $requestServiceBuilder)
    {   
        parent::__construct($handlerFactories, $requestServiceBuilder);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        $this->initHandlers();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET SETTINGS **********/
    /**********************************/

    /**
     * @return Array
     */

    public function getSettings(): array
    {
        $settings = [];
        $settings['visual_settings'] = $this->_getVisualSettings();
        $settings['current_user'] = $this->_getCurrentUser();
        $settings['current_post'] = $this->_getCurrentPost();
        $settings['apis'] = $this->_getAPIS();
        $settings['request_service'] = $this->_requestService;
        return $settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET VISUAL SETTINGS **********/
    /*****************************************/

    /**
     * @return Array
     */

    protected function _getVisualSettings(): array
    {
        $result = [];

        $visualSettings = $this->_requestService::buildRequestAndExecute([
            'type' => 'visual', 
            'action' => 'query'
            ], 
            [
            'method' => '', 
            'method_args' => [], 
            'query_args' => []
            ]);

        foreach($visualSettings as $visualSetting) {
            array_push($result, $visualSetting->getData());
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET CURRENT USER **********/
    /**************************************/

    /**
     * @return Array
     */

    protected function _getCurrentUser(): array
    {
        $result = [];
        $currentUser = $this->_requestService::buildRequestAndExecute([
            'type' => 'user', 
            'action' => 'query'
            ], 
            [
            'method' => 'current', 
            'method_args' => [], 
            'query_args' => []
            ]);

        $data = $currentUser->getCurrentUserData();

        if (!empty($data) && is_array($data) && count(array_filter($data)) > 0) {
            $result = $data;
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET CURRENT POST **********/
    /**************************************/

    /**
     * @return Array
     */

    protected function _getCurrentPost(): array
    {
        $result = [];
        $currentPost = $this->_requestService::buildRequestAndExecute([
            'type' => 'post', 
            'action' => 'query'
            ], 
            [
            'method' => 'current', 
            'method_args' => [], 
            'query_args' => []
            ]);

        $result['post'] = $currentPost;
        $result['meta'] = $currentPost->getAllMeta();
        $result['acf_fields'] = $currentPost->getAllAcfFields();
        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET APIS **********/
    /******************************/

    /**
     * @return Array
     */

    protected function _getAPIS(): array
    {
        $result = [];

        $apis = $this->_requestService::buildRequestAndExecute([
            'type' => 'api', 
            'action' => 'query'
            ], 
            [
            'method' => '', 
            'method_args' => [], 
            'query_args' => []
            ]);

        foreach($apis as $api) {
            array_push($result, $api->getData());
        }

        return $result;
    }
}