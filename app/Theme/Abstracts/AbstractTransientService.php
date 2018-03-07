<?php
/**
 * WP System - AbstractTransientService - Abstract Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\ITransientService as ITransientService;

/************************************************/
/********** ABSTRACT TRANSIENT SERVICE **********/
/************************************************/

class AbstractTransientService implements ITransientService
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

    protected static $_name;
    protected static $_lifeTime;
    protected static $_timeOut;
    protected static $_content;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET VALUES **********/
    /********************************/

    /**
     * @param String $name desired name
     * @param Int $lifeTime desired time
     */
    
    protected static function _setValues(string $name, int $lifeTime)
    {
        self::_setName($name);
        self::_setTimelife($lifeTime);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** RESET VALUES **********/
    /**********************************/

    protected static function _resetValues()
    {
        self::$_name = '';
        self::$_lifeTime = 0;
        self::$_timeOut = '';
        self::$_content = '';
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET NAME **********/
    /******************************/
    
    /**
     * @param String $name desired name
     */
    
    protected static function _setName(string $name)
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
        
        self::$_name = $transientName;
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** SET TIMELIFE **********/
    /**********************************/
    
    /**
     * @param Int $lifeTime desired time
     */
    
    protected static function _setTimelife(int $lifeTime)
    {
        $computedTime = $lifeTime;

        if ($computedTime < 1) {
            $computedTime = 5;
        }

        self::$_lifeTime = $computedTime * 60;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*********************************/
    /********** SET TIMEOUT **********/
    /*********************************/
    
    protected static function _setTimeOut()
    {
        $timeOut = get_option('_transient_timeout_' . self::$_name);
        self::$_timeOut = $timeOut;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*********************************/
    /********** SET CONTENT **********/
    /*********************************/

    protected static function _setContent()
    {
        $content = get_transient(self::$_name);
        self::$_content = $content;
    }

    /***********************************/
    /********** SET TRANSIENT **********/
    /***********************************/

    /**
     * @param Mixed transient's data                  
     */

    protected static function _setTransient($data) {
        self::$_content = $data;
        set_transient(self::$_name, self::$_content, self::$_lifeTime);
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /**********************************************************/
    /********** CHECK IF TRANSIENT HAS TO BE DELETED **********/
    /**********************************************************/
    
    /**
     * @return Bool
     */
    
    protected static function _checkIfTransientHasToBeDeleted(): bool
    {
        if (self::_checkIfTransientTimeOut()) {
            delete_transient(self::$_name);
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
    
    protected static function _checkIfTransientTimeOut(): bool
    {
        if (empty(self::$_timeOut)) {
            return true;
        }

        $time = time(); 
        if ($time > self::$_timeOut) {
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
    
    protected static function _checkIfTransientExists(): bool
    {
        if (get_transient(self::$_name) !== false) {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** REFERENCE TRANSIENT **********/
    /*****************************************/

    /**
     * @param String $transient transient name
     * @return Bool
     */

    protected static function _referenceTransient(string $transient): bool
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

    /**
     * @param String $transient transient name
     * @return Bool
     */

    protected static function _deleteTransient(string $transient): bool
    {    
        if (empty($transient)) {  
            return false;
        }     

        $registeredTransients = get_option('transients_list', []);

        if (($key = array_search($transient, $registeredTransients)) !== false) {
            unset($registeredTransients[$key]);
            update_option('transients_list', $registeredTransients);
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************/
    /********** GET **********/
    /*************************/

    /**
     * @return String
     */

    public static function get()
    {
        return get_class();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** OPERATE **********/
    /*****************************/

    /**
     * @param String $name transient name
     * @param Int $lifeTime transient lifetime
     * @return Mixed
     */

    public static function tryToRetrieveTransient(string $name, int $lifeTime = 5)
    {
        self::_resetValues();
        self::_setValues($name, $lifeTime);
        self::_referenceTransient(self::$_name);

        if (self::_checkIfTransientExists()) {
            self::_setTimeOut();
            if (self::_checkIfTransientHasToBeDeleted()) {
                return false;
            } else {
                self::_setContent();
                return self::$_content;
            }
        }
        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /************************************/
    /********** INIT TRANSIENT **********/
    /************************************/

    /**
     * @param String $name transient name
     * @param Int $lifeTime transient lifetime
     * @param Mixed $data transient data
     */

    public static function initTransient(string $name, int $lifeTime = 5, $data)
    {
        self::_resetValues();
        self::_setValues($name, $lifeTime);
        self::_referenceTransient(self::$_name);
        self::_setTransient($data);
    }
}