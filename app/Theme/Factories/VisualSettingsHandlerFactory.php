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

use App\Theme\Interfaces\IHandler as IHandler;
use App\Theme\Interfaces\IRepositoryBuilder as IRepositoryBuilder;
use App\Theme\Interfaces\IRequestService as IRequestService;
use App\Theme\Abstracts\AbstractHandlerFactory as AbstractHandlerFactory;
use App\Theme\Builders\VisualSettingsRepositoryBuilder as VisualSettingsRepositoryBuilder;
use App\Theme\Handlers\VisualSettingsHandler as VisualSettingsHandler;

/*****************************************************/
/********** VISUAL SETTINGS HANDLER FACTORY **********/
/*****************************************************/

class VisualSettingsHandlerFactory extends AbstractHandlerFactory
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
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
        return $this->_container->makeWith(VisualSettingsHandler::class, ['repositoryBuilder' => $this->_repositoryBuilder, 'requestService' => $requestService]);
    }
}