<?php
/**
 * WP System - CTHandlerFactory - Concrete Class
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
use App\Theme\Builders\CTRepositoryBuilder as CTRepositoryBuilder;
use App\Theme\Handlers\CTHandler as CTHandler;

/****************************************/
/********** CT HANDLER FACTORY **********/
/****************************************/

class CTHandlerFactory extends AbstractHandlerFactory
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
        $this->_repositoryBuilder = $this->_container->make(CTRepositoryBuilder::class);
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
        return $this->_container->makeWith(CTHandler::class, ['repositoryBuilder' => $this->_repositoryBuilder, 'requestService' => $requestService]);
    }
}