<?php
/**
 * WP Backend System - Transient Handler
 *
 * @since       15.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Transients;

/***************************************/
/********** TRANSIENT HANDLER **********/
/***************************************/

class TransientHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var TransientAdministrator $_transientAdministrator object that manage transients in backend
     * @var TransientOperator $_transientOperator object that manage transients in frontend
     */

    private $_transientAdministrator;
    private $_transientOperator;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param TransientAdministrator $transientAdministrator object that manage transients in backend
     * @param TransientOperator $transientOperator object that manage transients in frontend
     */

    public function __construct(TransientAdministrator $transientAdministrator, TransientOperator $transientOperator)
    {
        $this->_setValues($transientAdministrator, $transientOperator);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    /*
     * @param TransientAdministrator $transientAdministrator object that manage transients in backend
     * @param TransientOperator $transientOperator object that manage transients in frontend
     */

    private function _setValues(TransientAdministrator $transientAdministrator, TransientOperator $transientOperator)
    {
        $this->setTransientAdministrator($transientAdministrator);
        $this->setTransientOperator($transientOperator);
    }
 
    /**********/
    /********** TRANSIENT ADMINISTRATOR **********/
    /**********/
 
    /*
     * @param TransientAdministrator $transientAdministrator object that manage transients in backend
     */
 
    public function setTransientAdministrator(TransientAdministrator $transientAdministrator)
    {
        $this->_transientAdministrator = $transientAdministrator;
    }
 
    /**********/
    /********** TRANSIENT OPERATOR **********/
    /**********/
 
    /*
     * @param TransientOperator $transientOperator object that manage transients in frontend
     */
 
    public function setTransientOperator(TransientOperator $transientOperator)
    {
        $this->_transientOperator = $transientOperator;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** TRANSIENT ADMINISTRATOR **********/
    /**********/
 
    /*
     * @param TransientAdministrator
     */
 
    public function getTransientAdministrator(): TransientAdministrator
    {
        return $this->_transientAdministrator;
    }
  
    /**********/
    /********** TRANSIENT OPERATOR **********/
    /**********/
  
    /*
     * @param TransientOperator
     */
  
    public function getTransientOperator(): TransientOperator
    {
        return $this->_transientOperator;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GENERATE BACKEND VIEW **********/
    /*******************************************/

    private function _generateBackendView()
    {
        $this->_transientAdministrator->generateBackendView();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************/
    /********** INIT **********/
    /**************************/

    public function init()
    {
        try {
            $this->_generateBackendView();
        } catch (\Exception $e) {
            return false;
        }
    }

}