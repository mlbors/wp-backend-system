<?php
/**
 * WP Backend System - Front End
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Sides;

use \App\Theme\Managers\FrontManagerBuilder as FrontManagerBuilder;
use \App\Theme\Managers\Manager as Manager;

/*******************************/
/********** FRONT END **********/
/*******************************/

class FrontEnd implements Side
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var ManagerBuilder $_managerBuilder object that creates manager
     * @var Manager $_manager object that manages front-end or back-end
     */

    private $_managerBuilder;
    private $_manager;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        $this->_setValues();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    private function _setValues()
    {
        $this->setManagerBuilder();
    }

    /**********/
    /********** MANAGER BUILDER **********/
    /**********/

    public function setManagerBuilder()
    {
        $this->_managerBuilder = new FrontManagerBuilder();
    }

    /**********/
    /********** MANAGER **********/
    /**********/

    /*
     * @param Object $manager used manager
     */

    public function setManager(Manager $manager)
    {
        $this->_manager = $manager;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** MANAGER **********/
    /**********/

    /*
     * @return Manager
     */

    public function getManager(): Manager
    {
        return $this->_manager;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GENERATE **********/
    /******************************/

    public function generate()
    {
        try {
            $this->setManager($this->_managerBuilder->createManager());
            $this->_manager->init();
        } catch (\Exception $e) {
            return false;
        }

    }

}