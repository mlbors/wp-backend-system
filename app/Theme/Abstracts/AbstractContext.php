<?php
/**
 * WP System - AbstractContext - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IEntityFactory as IEntityFactory;

/**************************************/
/********** ABSTRACT CONTEXT **********/
/**************************************/

abstract class AbstractContext implements IContext
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IEntityFactory $_entityFactory object that create entities
     * @var String $_requestService object that manages requests (static class)
     * @var Mixed $_results last results
     */

    protected $_entityFactory;
    protected $_requestService;
    protected $_results;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntityFactory $entityFactory object that create entities
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IEntityFactory $entityFactory, string $requestService)
    {
        $this->_setValues($entityFactory, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IEntityFactory $entityFactory object that create entities
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setValues(IEntityFactory $entityFactory, string $requestService)
    {
        $this->_setEntityFactory($entityFactory);
        $this->_setRequestSerivce($requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** SET ENTITY FACTORY **********/
    /****************************************/

    /**
     * @param IEntityFactory $entityFactory object that create entities
     */

    protected function _setEntityFactory(IEntityFactory $entityFactory)
    {
        $this->_entityFactory = $entityFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    protected function _setRequestSerivce(string $requestService)
    {
        $this->_requestService = $requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** SET RESULTS **********/
    /*********************************/

    /**
     * @param Mixed $results last results
     */

    protected function _setResults($results)
    {
        $this->_results = $results;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** GET ENTITY FACTORY **********/
    /****************************************/

    /**
     * @return IContextFactory
     */

    public function getEntityFactory($entityFactory): IEntityFactory
    {
        return $this->_entityFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET SERVICE REQUEST **********/
    /*****************************************/

    /**
     * @return String
     */

    public function getServiceRequest(): string
    {
        return $this->_serviceRequest;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** GET RESULTS **********/
    /*********************************/

    /**
     * @return Mixed
     */

    public function getResults()
    {
        return $this->_results;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SWAP ENTITY FACTORY **********/
    /*****************************************/

    /**
     * @param IEntityFactory $entityFactory object that create entities
     */

    public function swapEntityFactory(IEntityFactory $entityFactory)
    {
        $this->_setEntityFactory($entityFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** EXECUTE QUERY **********/
    /***********************************/

    /**
     * @param String $action action to perform
     * @param Array $methodArgs args for method
     * @param Array $queryArgs args for query
     * @return Mixed
     */

    public function executeQuery(string $action, array $methodArgs, array $queryArgs)
    {
        $results = $this->{"_$action"}($methodArgs, $queryArgs);
        $preparedResults = $this->_prepareResults($results);
        $this->_setResults($preparedResults);

        return $this->_results;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** PREPARE RESULTS **********/
    /*************************************/

    /**
     * @param Mixed $results data returned by the query
     * @return Mixed
     */

    protected function _prepareResults($data)
    {
        if (is_array($data) && array_filter($data, 'is_object')) {
            $results = [];

            foreach($data as $d) {
                array_push($results, $this->createEntity($d));
            }
            return $results;
        }

        return $this->createEntity($data);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** CREATE ENTITY **********/
    /***********************************/

    /**
     * @param Mixed $data entity properties
     * @return IEntity
     */

    public function createEntity($data): IEntity {
        $entity = $this->_entityFactory->create($data);
        return $entity;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** CHECK QUERY ARGS **********/
    /**************************************/

    /**
     * @param Array $queryArgs args for query
     * @param Array $fields fields to check
     * @return Bool
     */

    protected function _checkQueryArgs($queryArgs, $fields = [])
    {
        if (empty($queryArgs) || !is_array($queryArgs) || count(array_filter($queryArgs)) === 0) {
            return false;
        }

        foreach($fields as $field) {
            if (empty($queryArgs[$field])) {
                return false;
            }
        }

        return true;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** CHECK ARRAY **********/
    /*********************************/

    /**
     * @param Object $array array to check
     * @return Boolean
     */

    private static function _checkArray($array): bool
    {
        if (empty($array)|| !is_array($array) || count(array_filter($array)) === 0 || !$array) {
            return false;
        }
        return true;
    }
}