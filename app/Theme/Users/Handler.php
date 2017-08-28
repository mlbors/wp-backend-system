<?php
/**
 * WP Backend System - User - Interface
 *
 * @since       11.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Users;

/*****************************/
/********** HANDLER **********/
/*****************************/

interface Handler
{
    public function setUserManager();
    public function setUserRolesManager();
    public function getUserManager(): UserManager;
    public function getUserRolesManager(): UserRolesManager;
}