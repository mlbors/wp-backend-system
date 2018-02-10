<?php
/**
 * WP System - AbstractRequestService - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IManager as IManager;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequestFactory as IRequestFactory;
use App\Theme\Interfaces\IConstraintsFactory as IConstraintsFactory;

/**********************************************/
/********** ABSTRACT REQUEST SERVICE **********/
/**********************************************/

class AbstractRequestService implements IRequestService
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IManager $_manager side manager
     * @var IRequest $_request request object
     * @var IRequestFactory $_requestFactory object that creates request
     * @var IConstraintsFactory $_constraintsFactory object that creates constraints
     */

    protected static $_manager;
    protected static $_request;
    protected static $_requestFactory;
    protected static $_constraintsFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    /**
     * @param IManager $manager side manager
     * @param IRequestFactory $requestFactory object that creates request
     * @param IConstraintsFactory $constraintsFactory object that creates constraints
     */

    public static function init(IManager $manager, IRequestFactory $requestFactory, IConstraintsFactory $constraintsFactory)
    {
        self::_setValues($manager, $requestFactory, $constraintsFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IManager $manager side manager
     * @param IRequestFactory $requestFactory object that creates request
     * @param IConstraintsFactory $constraintsFactory object that creates constraints
     */

    protected static function _setValues(IManager $manager, IRequestFactory $requestFactory, IConstraintsFactory $constraintsFactory)
    {
        self::_setManager($manager);
        self::_setRequestFactory($requestFactory);
        self::_setConstraintsFactory($constraintsFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** SET MANAGER **********/
    /*********************************/

    /**
     * @param IManager $manager side manager
     */

    protected static function _setManager(IManager $manager)
    {
        self::$_manager = $manager;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST FACTORY **********/
    /*****************************************/

    /**
     * @param IRequestFactory $requestFactory object that creates request
     */

    protected static function _setRequestFactory(IRequestFactory $requestFactory)
    {
        self::$_requestFactory = $requestFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** SET CONSTRAINTS FACTORY **********/
    /*********************************************/

    /**
     * @param IConstraintsFactory $constraintsFactory object that creates constraints
     */

    protected static function _setConstraintsFactory(IConstraintsFactory $constraintsFactory)
    {
        self::$_constraintsFactory = $constraintsFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** SET REQUEST **********/
    /*********************************/

    /**
     * @param IRequest $request request object
     */

    protected static function _setRequest(IRequest $request)
    {
        self::$_request = $request;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** GET MANAGER **********/
    /*********************************/

    /**
     * @return IManager
     */

    public static function getManager(): IManager
    {
        return self::$_manager;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET REQUEST FACTORY **********/
    /*****************************************/

    /**
     * @return IRequestFactory
     */

    public static function getRequestFactory(): IRequestFactory
    {
        return self::$_requestFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** GET CONSTRAINTS FACTORY **********/
    /*********************************************/

    /**
     * @return IConstraintsFactory
     */

    public static function getConstraintsFactory(): IConstraintsFactory
    {
        return self::$_constraintsFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** GET **********/
    /*************************/

    /**
     * @return String
     */

    public static function get()
    {
        return get_class();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SWAP MANAGER **********/
    /**********************************/

    /**
     * @param IManager $manager side manager
     */

    public static function swapManager(IManager $manager)
    {
        self::_setManager($manager);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** SWAP REQUEST FACTORY **********/
    /******************************************/

    /**
     * @param IRequestFactory $requestFactory object that creates request
     */

    public static function swapRequestFactory(IRequestFactory $requestFactory)
    {
        self::_setRequestFactory($requestFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** SWAP CONSTRAINTS FACTORY **********/
    /**********************************************/

    /**
     * @param IConstraintsFactory $constraintsFactory object that creates constraints
     */

    public static function swapConstraintsFactory(IConstraintsFactory $constraintsFactory)
    {
        self::_setConstraintsFactory($constraintsFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** BUILD REQUEST **********/
    /***********************************/

    /**
     * @param Array $args request arguments
     * @param Array $constraints request constraints
     * @return IRequest
     */

    public static function buildRequest(array $args = [], array $constraints = []): IRequest
    {
        $requestConstraints = self::$_constraintsFactory->create();
        $requestConstraints->set($constraints);
        $request = self::$_requestFactory->create();
        $request->set($args, $requestConstraints);
        self::_setRequest($request);
        return $request;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** EXECUTE REQUEST **********/
    /*************************************/

    /**
     * @return Mixed
     */

    public static function executeRequest()
    {
        try {
            return self::$_manager->dispatchRequest(self::$_request);
        } catch (\Exception $e) {
            return false;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** BUILD AND EXECUTE REQUEST **********/
    /***********************************************/

    /**
     * @param Array $args request arguments
     * @param Array $constraints request constraints
     * @return Mixed
     */

    public static function buildRequestAndExecute(array $args = [], array $constraints = []) {
        self::buildRequest($args, $constraints);
        return self::executeRequest();
    }
}