<?php
/**
 * WP System - AbstractShortcodeState - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;

/**********************************************/
/********** ABSTRACT SHORTCODE STATE **********/
/**********************************************/

abstract class AbstractShortcodeState implements IState
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IEntity $_entity entity object
     * @var String $_transientService object that manages transients (static class)
     * @var String $_requestService object that manages requests (static class)
     * @var Array $_data shortcode's data
     * @var Mixed $_result shortcode's result
     */

    protected $_entity;
    protected $_transientService;
    protected $_requestService;
    protected $_data = [];
    protected $_result;

    /*********************************************************************************/
    /*********************************************************************************/

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
        $this->_setValues($entity, $transientService, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IEntity $entity entity object
     * @param String $transientService object that manages transients (static class)
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setValues(IEntity $entity, string $transientService, string $requestService)
    {
        $this->_setEntity($entity);
        $this->_setTransientService($transientService);
        $this->_setRequestService($requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET ENTITY **********/
    /********************************/

    /**
     * @param IEntity $entity entity object
     */

    protected function _setEntity(IEntity $entity)
    {
        $this->_entity = $entity;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*******************************************/
    /********** SET TRANSIENT SERVICE **********/
    /*******************************************/

    /**
     * @param String $transientService object that manages transients (static class)
     */

    protected function _setTransientService($transientService)
    {
        $this->_transientService = $transientService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setRequestService(string $requestService)
    {
        $this->_requestService = $requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET DATA **********/
    /******************************/

    /**
     * @param Array $data shortcode's data
     */

    protected function _setData(array $data)
    {
        $this->_data = $data;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET RESULT **********/
    /********************************/

    /**
     * @param Mixed $result shortcode's result
     */

    protected function _setResult($result)
    {
        $this->_result = $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** GET ENTITY **********/
    /********************************/

    public function getEntity(): IEntity
    {
        return $this->_entity;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GET TRANSIENT SERVICE **********/
    /*******************************************/

    /**
     * @return string
     */

    public function getTransientService()
    {
        return $this->_transientService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @return String
     */

    public function getRequestService(): string
    {
        return $this->_requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GET DATA **********/
    /******************************/

    /**
     * @return Array
     */

    protected function getData(): array
    {
        return $this->_data;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** GET RESULT **********/
    /********************************/

    /**
     * @return Mixed
     */

    protected function getResult()
    {
        return $this->_result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** RENDER SHORTCODE **********/
    /**************************************/

    /**
     * @return Mixed
     */

    protected function _renderShortcode()
    {
        try {
            ob_start();
            
            $view = '';

            if (!empty($this->_data['view'])) {
                $view = $this->_data['view']; 
            }

            if ($view === 'other' || (empty($view) && !empty($this->_data['view_other']))) {
                $view = $this->_data['view_other'];
            }

            $template = 'shortcodes/' . $view;
            echo \App\template($template, ['data' => $this->_result]);
            return ob_get_clean();
        } catch (\Exception $e) {
            return false;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** EXECUTE QUERY **********/
    /***********************************/

    /**
     * @return Mixed
     */

    abstract protected function _executeQuery();

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** PREPROCESS SHORTCODE **********/
    /******************************************/

    protected function _preprocesShortcode()
    {
        $this->_executeQuery();
        return $this->_renderShortcode();
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*************************************/
    /********** BUILD SHORTCODE **********/
    /*************************************/

    /**
     * @return Mixed
     */

    protected function _buildShortcode()
    {
        if (!empty($this->_data['use_transient'])) {
            
            $possibleTransient = $this->_transientService::tryToRetrieveTransient($this->_entity->name);

            if ($possibleTransient) {
                return $possibleTransient;
            } else {
                $render = $this->_preprocesShortcode();
                $this->_transientService::initTransient($this->_entity->name, $this->_data['transient_time'], $render);
                return $render;
            }

        }

        return $this->_preprocesShortcode();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** REGISTER **********/
    /******************************/

    protected function _registerShortcode()
    {
        $class = $this;
        add_shortcode($this->_entity->name, function() use ($class) {
            return $class->_buildShortcode();
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    abstract public function execute();
}