<?php
/**
 * WP System - BackManager - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Managers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IRequestServiceBuilder as IRequestServiceBuilder;
use App\Theme\Interfaces\IViewControllerFactory as IViewControllerFactory;
use App\Theme\Interfaces\IViewController as IViewController;
use App\Theme\Abstracts\AbstractManager as AbstractManager;
use App\Theme\Helpers\ACFOptionsHelper as ACFOptionsHelper;

/**********************************/
/********** BACK MANAGER **********/
/**********************************/

class BackManager extends AbstractManager
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IViewControllerFactory $_viewControllerFactory object that creates view controllers
     * @var IViewController $_viewController object that renders views
     */

    protected $_viewController;
    protected $_viewControllerFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param Array $handlersFactories array object that creates handlers
     * @param IRequestServiceBuilder $requestServiceBuilder object that creates request services
     * @param IViewControllerFactory $_viewControllerFactory object that creates view controllers
     */

    public function __construct(array $handlerFactories, IRequestServiceBuilder $requestServiceBuilder, IViewControllerFactory $viewControllerFactory)
    {   
        parent::__construct($handlerFactories, $requestServiceBuilder);
        $this->_setManagerValues($viewControllerFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        ACFOptionsHelper::initACFOptions();
        $this->initHandlers();
        $this->_viewController->display();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** SET MANAGER VALUES **********/
    /****************************************/

    /**
     * @param IViewControllerFactory $_viewControllerFactory object that creates view controllers
     */

    protected function _setManagerValues(IViewControllerFactory $viewControllerFactory)
    {
        $this->_setViewControllerFactory($viewControllerFactory);
        $this->_instantiateViewController();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET VIEW CONTROLLER **********/
    /*****************************************/

    /**
     * @param IViewController $_viewController object that renders views
     */

    protected function _setViewController(IViewController $viewController)
    {
        $this->_viewController = $viewController;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** SET VIEW CONTROLLER FACTORY **********/
    /*************************************************/

    /**
     * @param IViewControllerFactory $_viewControllerFactory object that creates view controllers
     */

    protected function _setViewControllerFactory(IViewControllerFactory $viewControllerFactory)
    {
        $this->_viewControllerFactory = $viewControllerFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET VIEW CONTROLLER **********/
    /*****************************************/

    /**
     * @return IViewController
     */

    public function getViewController(): IViewController 
    {
        return $this->_viewController;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** GET VIEW CONTROLLER FACTORY **********/
    /*************************************************/

    /**
     * @return IViewControllerFactory
     */

    public function getViewControllerFactory(): IViewControllerFactory
    {
        return $this->_viewControllerFactory;
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
        $settings['current_user'] = $this->_getCurrentUser();
        return $settings;
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

    /*************************************************/
    /********** INSTANTIATE VIEW CONTROLLER **********/
    /*************************************************/

    protected function _instantiateViewController()
    {
        $this->_setViewController($this->_viewControllerFactory->create());
    }
}