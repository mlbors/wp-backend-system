<?php
/**
 * WP System - BackSide - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Sides;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractSide as AbstractSide;

/*******************************/
/********** BACK SIDE **********/
/*******************************/

class BackSide extends AbstractSide
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param Array $managerBuilders array of object that builds managers
     */

    public function __construct(array $managerBuilders)
    {
        parent::__construct($managerBuilders);
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
        foreach($this->_managers as $manager) {
            array_push($settings, $manager->getSettings());
        }
        return $settings;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        $this->initManagers();
    }
}