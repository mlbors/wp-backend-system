<?php
/**
 * WP Backend System - User Manager
 *
 * @since       11.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Users;

use WP_User;

/**********************************/
/********** USER MANAGER **********/
/**********************************/

class UserManager
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var WP_User $_currentUser current user object
     * @var Bool $_currentuserLoggedIn is the current user logged in
     */

    private $_currentUser;
    private $_currentUserLoggedIn;

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
        $this->_setCurrentUser();
        $this->_setUserLoggedIn();
    }

    /**********/
    /********** CURRENT USER **********/
    /**********/

    private function _setCurrentUser()
    {
        $this->_currentUser = new WP_User(get_current_user_id());
    }

    /**********/
    /********** CURRENT USER IS LOGGED **********/
    /**********/

    private function _setUserLoggedIn()
    {
        $this->_currentUserLoggedIn = is_user_logged_in();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GET CURRENT USER ROLE **********/
    /*******************************************/

    /*
     * @return Mixed String || False
     */

    public function getCurrentUserRole() 
    { 
        if (!$this->_currentUserLoggedIn) {
            return false;
        }

        if (empty($this->_currentUser->roles) || !is_array($this->_currentUser->roles)) {
            return false;
        }

        return (string) $this->_currentUser->roles[0];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************************/
    /********** GET CURRENT USER BASIC DATA **********/
    /*************************************************/

    /*
     * @return Mixed String || False
     */

    public function getCurrentUserBasicData()
    {
        if (!$this->_currentUserLoggedIn) {
            return false;
        }

        return (array) $this->_currentUser->data;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GET CURRENT USER DATA **********/
    /*******************************************/

    /*
     * @return Array
     */

    public function getCurrentUserData()
    {
        $array = [];

        $array['data'] = $this->getCurrentUserBasicData();
        $array['role'] = $this->getCurrentUserRole();

        return $array;
    }

}