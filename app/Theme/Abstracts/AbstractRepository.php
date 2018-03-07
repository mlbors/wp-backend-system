<?php
/**
 * WP System - AbstractRepository - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraints as IConstraints;
use App\Theme\Interfaces\IContext as IContext;
use App\Theme\Interfaces\IContextFactory as IContextFactory;
use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IRepository as IRepository;
use App\Theme\Interfaces\IThemeObject as IThemeObject;
use App\Theme\Interfaces\IThemeObjectBuilder as IThemeObjectBuilder;

/*****************************************/
/********** ABSTRACT REPOSITORY **********/
/*****************************************/

abstract class AbstractRepository implements IRepository
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IContext $_context data context
     * @var IContextFactory $_contextFactory object that creates data context
     * @var IThemeObjectBuilder $_themeObjectBuilder object that build theme object
     * @var String $_requestService object that manages requests (static class)
     * @var Mixed $_results last results
     * @var String $_type repository type
     */

    protected $_context;
    protected $_contextFactory;
    protected $_themeObjectBuilder;
    protected $_requestService;
    protected $_results;
    protected $_type;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IContextFactory $contextFactory object that creates data context
     * @param IThemeObjectBuilder $themeObjectBuilder object that build theme object
     * @param String $requestService object that manages requests (static class)
     * @param String $type repository type
     */

    public function __construct(IContextFactory $contextFactory, IThemeObjectBuilder $themeObjectBuilder, string $requestService, string $type)
    {
        $this->_setValues($contextFactory, $themeObjectBuilder, $requestService, $type);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param IContextFactory $contextFactory object that creates data context
     * @param IThemeObjectBuilder $themeObjectBuilder object that build theme object
     * @param String $requestService object that manages requests (static class)
     * @param String $type repository type
     */

    protected function _setValues(IContextFactory $contextFactory, IThemeObjectBuilder $themeObjectBuilder, string $requestService, string $type)
    {
        $this->_setContextFactory($contextFactory);
        $this->_setThemeObjectBuilder($themeObjectBuilder);
        $this->_setRequestSerivce($requestService);
        $this->_setType($type);
        $this->_instantiateContext();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** SET CONTEXT **********/
    /*********************************/

    /**
     * @param IContext $context data context
     */

    protected function _setContext(IContext $context)
    {
        $this->_context = $context;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET CONTEXT FACTORY **********/
    /*****************************************/

    /**
     * @param IContextFactory $contextFactory object that creates data context
     */

    protected function _setContextFactory(IContextFactory $contextFactory)
    {
        $this->_contextFactory = $contextFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** SET THEME OBJECT BUILDER **********/
    /**********************************************/

    /**
     * @param IThemeObjectBuilder $themeObjectBuilder object that build theme object
     */

    protected function _setThemeObjectBuilder(IThemeObjectBuilder $themeObjectBuilder)
    {
        $this->_themeObjectBuilder = $themeObjectBuilder;
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

    /******************************/
    /********** SET TYPE **********/
    /******************************/

    /**
     * @param String $type repository type
     */

    protected function _setType(string $type)
    {
        $this->_type = $type;
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

    /*********************************/
    /********** GET CONTEXT **********/
    /*********************************/

    /**
     * @return IContext
     */

    public function getContext($context): IContext
    {
        return $this->_context;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** GET CONTEXT FACTORY **********/
    /*****************************************/

    /**
     * @return IContextFactory
     */

    public function getContextFactory($contextFactory): IContextFactory
    {
        return $this->_contextFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** GET THEME OBJECT BUILDER **********/
    /**********************************************/

    /**
     * @return IThemeObjectBuilder
     */

    public function getThemeObjectBuilder($themeObjectBuilder): IThemeObjectBuilder
    {
        return $this->_themeObjectBuilder;
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

    /******************************/
    /********** GET TYPE **********/
    /******************************/

    /**
     * @return String
     */

    protected function getType(): string
    {
        return $this->_type;
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
    /********** INSTANTIATE CONTEXT **********/
    /*****************************************/

    protected function _instantiateContext()
    {
        $this->_setContext($this->_contextFactory->create($this->_requestService));
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SWAP CONTEXT **********/
    /**********************************/

    /**
     * @param IContextFactory $contextFactory object that creates data context
     */

    public function swapContext(IContextFactory $contextFactory)
    {
        $this->_setContextFactory($contextFactory);
        $this->_instantiateContext();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** SWAP THEME OBJECT BUILDER **********/
    /***********************************************/

    /**
     * @param IThemeObjectBuilder $themeObjectBuilder object that build theme object
     */

    public function swapThemeObjectBuilder(IThemeObjectBuilder $themeObjectBuilder)
    {
        $this->_setThemeObjectBuilder($themeObjectBuilder);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** CREATE THEME OBJECT **********/
    /*****************************************/

    /**
     * @param IEntity $entity entity object
     * @return IThemeObject
     */

    protected function _createThemeObject(IEntity $entity): IThemeObject
    {
        return $this->_themeObjectBuilder->create($entity);
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
        if (is_array($data)) {
            $results = [];

            foreach($data as $d) {
                array_push($results, $this->_createThemeObject($d));
            }

            return $results;
        }

        return $this->_createThemeObject($data);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** EXECUTE QUERY **********/
    /***********************************/

    /**
     * @param String $action action to perform
     * @param IConstraints $constraints constraints for query
     */

    protected function _executeQuery(string $action, IConstraints $constraints)
    {
        $results = $this->_context->executeQuery($action, $constraints->args['method_args'], $constraints->args['query_args']);
        $preparedResults = $this->_prepareResults($results);
        $this->_setResults($preparedResults);
        return $this->_results;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************/
    /********** QUERY **********/
    /***************************/

    /**
     * @param IConstraints $constraints constraints for query
     */

    public function query(IConstraints $constraints)
    {
        $action = 'query' . ucfirst($this->_type) . $constraints->args['method'];
        return $this->_executeQuery($action, $constraints);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** UPDATE **********/
    /****************************/

    /**
     * @param IConstraints $constraints constraints for query
     */

    public function update(IConstraints $constraints)
    {
        $action = 'update' . ucfirst($this->_type) . $constraints->args['method'];
        return $this->_executeQuery($action, $constraints);
    }
}