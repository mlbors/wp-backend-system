<?php
/**
 * WP System - VisualSettingsHandlerFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IGeneratorFactory as IGeneratorFactory;
use App\Theme\Interfaces\IHandler as IHandler;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Abstracts\AbstractHandlerFactory as AbstractHandlerFactory;
use App\Theme\Builders\VisualSettingsRepositoryBuilder as VisualSettingsRepositoryBuilder;
use App\Theme\Factories\CSSGeneratorFactory as CSSGeneratorFactory;
use App\Theme\Handlers\VisualSettingsHandler as VisualSettingsHandler;

/*****************************************************/
/********** VISUAL SETTINGS HANDLER FACTORY **********/
/*****************************************************/

class VisualSettingsHandlerFactory extends AbstractHandlerFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var IGeneratorFactory $_cssGeneratorFactory object that creates CSS Generator
     */

    protected $_cssGeneratorFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
        $this->_setCSSGeneratorFactory();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************************/
    /********** SET CSS GENERRATOR FACTORY **********/
    /************************************************/

    protected function _setCSSGeneratorFactory()
    {
        $this->_cssGeneratorFactory = $this->_container->make(CSSGeneratorFactory::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** SET REPOSITORY BUIDER **********/
    /*******************************************/

    protected function _setRepositoryBuilder()
    {
        $this->_repositoryBuilder = $this->_container->make(VisualSettingsRepositoryBuilder::class);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE HANDLER **********/
    /************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     * @return IHandler
     */

    protected function _createHandler($requestService): IHandler
    {
        return $this->_container->makeWith(VisualSettingsHandler::class, ['repositoryBuilder' => $this->_repositoryBuilder, 'requestService' => $requestService, 'cssGeneratorFactory' => $this->_cssGeneratorFactory]);
    }
}