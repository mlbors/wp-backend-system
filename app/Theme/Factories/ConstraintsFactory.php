<?php
/**
 * WP System - ConstraintsFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IConstraints as IConstraints;
use App\Theme\Abstracts\AbstractConstraintsFactory as AbstractConstraintsFactory;
use App\Theme\Constraints\Constraints as Constraints;

/*****************************************/
/********** CONSTRAINTS FACTORY **********/
/*****************************************/

class ConstraintsFactory extends AbstractConstraintsFactory
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

    /****************************************/
    /********** CREATE CONSTRAINTS **********/
    /****************************************/

    /**
     * @return IConstraints
     */

    protected function _createConstraints(): IConstraints
    {
        return $this->_container->make(Constraints::class);
    }
}