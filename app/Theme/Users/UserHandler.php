<?php
/**
 * WP Backend System - User Handler
 *
 * @since       11.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Users;

/**********************************/
/********** USER HANDLER **********/
/**********************************/

class UserHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var UserManager $_userManager object that handles user
     * @var UserRolesManager $_userRolesManager object that handles roles and capabilities
     */

    private $_userManager;
    private $_userRolesManager;

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
        $this->setUserManager();
        $this->setUserRolesManager();
    }

    /**********/
    /********** USER MANAGER **********/
    /**********/

    public function setUserManager()
    {
        $this->_userManager = new UserManager();
    }

    /**********/
    /********** USER ROLES MANAGER **********/
    /**********/

    public function setUserRolesManager()
    {
        $this->_userRolesManager = new UserRolesManager();
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** USER MANAGER **********/
    /**********/

    public function getUserManager(): UserManager
    {
        return $this->_userManager;
    }

    /**********/
    /********** USER ROLES MANAGER **********/
    /**********/

    public function getUserRolesManager(): UserRolesManager
    {
        return $this->_userRolesManager;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET USER ROLES **********/
    /************************************/

    public function setUpUserRoles()
    {
        try {
            $this->_userRolesManager->setUpUserRoles();
        } catch (\Exception $e) {
            return false;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************************/
    /********** SET USER ROLES PURGE PAGE **********/
    /***********************************************/

    public function generatePurgePage()
    {
        try {
            $this->_userRolesManager->generatePurgePage();
        } catch (\Exception $e) {
            return false;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /*******************************************/
    /********** GET CURRENT USER DATA **********/
    /*******************************************/

    /*
     * @return Array
     */

    public function getCurrentUserData(): array
    {
        try {
            return $this->_userManager->getCurrentUserData();
        } catch (\Exception $e) {
            return [];
        }
    }
 
}