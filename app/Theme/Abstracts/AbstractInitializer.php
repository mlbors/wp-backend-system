<?php
/**
 * WP System - AbstractInitializer - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\ISideFacade as ISideFacade;
use App\Theme\Interfaces\ISideFacadeFactory as ISideFacadeFactory;
use App\Theme\Interfaces\IInitializer as IInitializer;

/******************************************/
/********** ABSTRACT INITIALIZER **********/
/******************************************/

abstract class AbstractInitializer implements IInitializer
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Array $_settings array of settings
     * @var ISideFacade $_sideFacade main side facade
     * @var ISideFacadeFactory $_sideFacadeFactory object that creates side facade
     */

    protected $_settings = [];
    protected $_sideFacade;
    protected $_sideFacadeFactory;

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    abstract public function init();

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SET SETTINGS **********/
    /**********************************/

    protected function _setSettings($settings)
    {
        $this->_settings = $settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** SET SIDE FACADE **********/
    /*************************************/

    /*  
     * @param ISideFacade $sideFacade main facade
     */

    protected function _setSideFacade(ISideFacade $sideFacade)
    {
        $this->_sideFacade = $sideFacade;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** SET SIDE FACADE FACTORY **********/
    /*********************************************/

    /**
     * @var ISideFacadeFactory $sideFacadeFactory object that creates side facade
     */

    protected function _setSideFacadeFactory(ISideFacadeFactory $sideFacadeFactory)
    {
        $this->_sideFacadeFactory = $sideFacadeFactory;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GET SETTINGS **********/
    /**********************************/

    abstract public function getSettings(): array;

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** GET SIDE FACADE **********/
    /*************************************/

    /**
     * @return ISideFacade
     */

    public function getSideFacade(ISideFacade $sideFacade)
    {
        return $this->_sideFacade;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************************/
    /********** GET SIDE FACADE FACTORY **********/
    /*********************************************/

    /**
     * @return ISideFacadeFactory
     */

    public function getSideFacadeFactory(ISideFacadeFactory $sideFacadeFactory)
    {
        return $this->_sideFacadeFactory;
    }
}