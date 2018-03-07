<?php
/**
 * WP System - VisualSettingsHandler - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Handlers;

use Roots\Sage\Container;

use App\Theme\Interfaces\IApplyer as IApplyer;
use App\Theme\Interfaces\IGenerator as IGenerator;
use App\Theme\Interfaces\IGeneratorFactory as IGeneratorFactory;
use App\Theme\Interfaces\IGetter as IGetter;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Interfaces\IRequest as IRequest;
use App\Theme\Abstracts\AbstractHandler as AbstractHandler;

/*********************************************/
/********** VISUAL SETTINGS HANDLER **********/
/*********************************************/

class VisualSettingsHandler extends AbstractHandler implements IApplyer
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Mixed $_settings visual settings
     * @var IGenerator $_cssGenerator object that creates CSS files
     * @var IGeneratorFactory $_cssGeneratorFactory object that creates CSS Generator
     */

    protected $_settings;
    protected $_cssGenerator;
    protected $_cssGeneratorFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IRepositoryBuilder $repositoryBuilder object that creates repositories
     * @param String $requestService object that manages requests (static class)
     * @param IGeneratorFactory $cssGeneratorFactory object that creates CSS Generator
     */

    public function __construct(IRepositoryBuilder $repositoryBuilder, string $requestService, IGeneratorFactory $cssGeneratorFactory)
    {
        parent::__construct($repositoryBuilder, $requestService); 
        $this->_setHandlerValues($cssGeneratorFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        $this->get();
        $this->apply();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** SET HANDLER VALUES **********/
    /****************************************/

    /**
     * @param IGeneratorFactory $cssGeneratorFactory object that creates CSS Generator
     */

    protected function _setHandlerValues(IGeneratorFactory $cssGeneratorFactory)
    {
        $this->_setCSSGeneratorFactory($cssGeneratorFactory);
        $this->_instantiateCSSGenerator();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** SET CSS GENERATOR FACTORY **********/
    /***********************************************/

    /**
     * @param IGeneratorFactory $cssGeneratorFactory object that creates CSS Generator
     */

    protected function _setCSSGeneratorFactory(IGeneratorFactory $cssGeneratorFactory)
    {
        $this->_cssGeneratorFactory = $cssGeneratorFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** SET CSS GENERATOR **********/
    /***************************************/

    /**
     * @param IGenerator $cssGenerator object that creates CSS files
     */

    protected function _setCSSGenerator(IGenerator $cssGenerator)
    {
        $this->_cssGenerator = $cssGenerator;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SET SETTINGS **********/
    /**********************************/

    /**
     * @param Mixed $settings visual settings
     */

    protected function _setSettings($settings)
    {
        $this->_settings = $settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** GET CSS GENERATOR FACTORY **********/
    /***********************************************/

    /**
     * @return IGeneratorFactory
     */

    public function getCSSGeneratorFactory(): IGeneratorFactory
    {
        return $this->_cssGeneratorFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** GET CSS GENERATOR **********/
    /***************************************/

    /**
     * @return IGenerator
     */

    public function getCSSGenerator(): IGenerator
    {
        return $this->_cssGenerator;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET SETTINGS **********/
    /**********************************/

    /**
     * @return Mixed
     */

    protected function getSettings()
    {
        return $this->_settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** INSTANTIATE CSS GENERATOR **********/
    /***********************************************/

    protected function _instantiateCSSGenerator()
    {
        $this->_setCSSGenerator($this->_cssGeneratorFactory->create());
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CAN HANDLE REQUEST **********/
    /****************************************/

    /**
     * @return Bool
     */

    public function canHandleRequest(IRequest $request): bool
    {
        if (empty($request->args['type']) || empty($request->args['action'])) {
            return false;
        }

        if ($request->args['type'] === 'visual' && method_exists($this->_repository, $request->args['action'])) {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** HANDLE REQUEST **********/
    /************************************/

    public function handleRequest(IRequest $request)
    {
        $action = $request->args['action'];
        $result = $this->_repository->{"$action"}($request->constraints);
        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** GET **********/
    /*************************/

    public function get()
    {
        $result = [];
        $settings = $this->_getVisualSettings();
        foreach($settings as $setting) {
            array_push($result, $setting->getData());
        }
        $this->_setSettings($result);
        return $this->_settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************/
    /********** APPLY **********/
    /***************************/

    public function apply()
    {
        $this->_cssGenerator->setData($this->_settings);
        $this->_cssGenerator->generate();
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
        $array = [];
        $request = $this->_requestService::buildRequest([
            'type' => 'visual', 
            'action' => 'query'
            ], 
            [
            'method' => '', 
            'method_args' => [], 
            'query_args' => []
            ]);
        $result = $this->handleRequest($request);

        if (!empty($result) && is_array($result)) {
            $array = $result;
        }

        return $array;
    }
}