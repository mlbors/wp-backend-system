<?php
/**
 * WP Backend System - Main Transient Operator
 *
 * @since       15.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Transients;

/********************************************/
/********** MAIN TAXONOMIE CREATOR **********/
/********************************************/

class MainTransientOperator implements TransientOperator
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var String $_name ransient name
     * @var Int $_lifeTime transient timelife
     * @var Int $_timeOut transient timeout
     * @var String $_content transient content
     */

    private $_name;
    private $_lifeTime;
    private $_timeOut;
    private $_content;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    /**
     * @param String $name desired name
     * @param Int $lifeTime desired time
     */
    
    private function _setValues(string $name, int $lifeTime)
    {
        $this->_setName($name);
        $this->_setTimelife($lifeTime);
    }

    /**********/
    /********** NAME **********/
    /**********/
    
    /**
     * @param String $name desired name
     */
    
    private function _setName(string $name)
    {
        wp_reset_postdata();
        global $post;

        $transientName = '';
        $transientName .= $name;

        if (!empty($post)) {
            $transientName .= '_' . $post->ID;
        }
        
        if (function_exists('icl_object_id')) {
            $transientName .= '_' . ICL_LANGUAGE_CODE;
        }
        
        $this->_name = $transientName;
    }
    
    /**********/
    /********** TIMELIFE **********/
    /**********/
    
    /**
     * @param Int $lifeTime desired time
     */
    
    private function _setTimelife(int $lifeTime)
    {
        $computedTime = $lifeTime;

        if ($computedTime < 1) {
            $computedTime = 5;
        }

        $this->_lifeTime = $computedTime * 60;
    }
    
    /**********/
    /********** TIMEOUT **********/
    /**********/
    
    private function _setTimeOut()
    {
        $timeOut = get_option('_transient_timeout_' . $this->_name);
        $this->_timeOut = $timeOut;
    }
    
    /**********/
    /********** CONTENT **********/
    /**********/

    private function _setContent()
    {
        $content = get_transient($this->_name);
        $this->_content = $content;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** SET THE TRANSIENT **********/
    /***************************************/

    /**
     * @param Mixed transient's data                  
     */

    private function _setTheTransient($data) {
        $this->_content = $data;
        set_transient($this->_name, $this->_content, $this->_lifeTime);
    }
    
    /*********************************************************************************/
    /*********************************************************************************/
    
    /******************************************/
    /********** TRY TO SET TRANSIENT **********/
    /******************************************/
    
    /**
     * @param Mixed transient's data                  
     * @return Bool
     */
    
    private function _tryToSetTransient($data): bool
    { 
        if ( $this->_checkIfTransientContentCanBeSet() ) {
            $this->_setTheTransient($data);
            return true;
        }
        return false;
    }
    
    /*********************************************************************************/
    /*********************************************************************************/
    
    /**********************************************************/
    /********** CHECK IF TRANSIENT HAS TO BE DELETED **********/
    /**********************************************************/
    
    /**
     * @return Bool
     */
    
    private function _checkIfTransientHasToBeDeleted(): bool
    {
        if ($this->_checkIfTransientTimeOut()) {
            delete_transient($this->_name);
            return true;
        }
        return false;
    }
  
    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************************/
    /********** CHECK IF TRANSIENT IS TIME OUT **********/
    /****************************************************/
    
    /**
     * @return Bool
     */
    
    private function _checkIfTransientTimeOut(): bool
    {
        if (empty($this->_timeOut)) {
            return true;
        }

        $time = time(); 
        if ($time > $this->_timeOut) {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** CHECK IF TRANSIENT EXISTS **********/
    /***********************************************/
    
    /**
     * @return Bool
     */
    
    private function _checkIfTransientExists(): bool
    {
        if (get_transient($this->_name) !== false) {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** REFERENCE TRANSIENT **********/
    /*****************************************/

    /*
     * @param String $transient transient name
     * @return Bool
     */

    private function _referenceTransient(string $transient): bool
    {
        if (empty($transient)) {  
            return false;
        }    

        $registeredTransients = get_option('transients_list', []);

        if (!in_array($transient, $registeredTransients)) {
            array_push($registeredTransients, $transient);
            update_option('transients_list', $registeredTransients);
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /**************************************/
    /********** DELETE TRANSIENT **********/
    /**************************************/

    /*
     * @param String $transient transient name
     * @return Bool
     */

    private function _deleteTransient(string $transient): bool
    {    
        if (empty($transient)) {  
            return false;
        }     

        $registeredTransients = get_option('transients_list', []);

        if (($key = array_search($transient, $this->transientsArray)) !== false) {
            unset($registeredTransients[$key]);
            update_option('transients_list', $registeredTransients);
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************/
    /********** OPERATE **********/
    /*****************************/

    /*
     * @param String $name transient name
     * @param Int $lifeTime transient lifetime
     * @return Mixed
     */

    public function operate(string $name, int $lifeTime = 5)
    {
        $this->_setValues($name, $lifeTime);
        $this->_referenceTransient($this->_name);

        if ($this->_checkIfTransientExists()) {
            $this->_setTimeOut();
            if ($this->_checkIfTransientHasToBeDeleted()) {
                return false;
            } else {
                $this->_setContent();
                return $this->_content;
            }
        }
        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /************************************/
    /********** INIT TRANSIENT **********/
    /************************************/

    /*
     * @param String $name transient name
     * @param Int $lifeTime transient lifetime
     * @param Mixed $data transient data
     */

    public function initTransient(string $name, int $lifeTime = 5, $data)
    {
        $this->_setValues($name, $lifeTime);
        $this->_referenceTransient($this->_name);
        $this->_setTheTransient($data);
    }

}