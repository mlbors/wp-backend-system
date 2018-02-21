<?php
/**
 * WP System - FilesHelper - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Helpers;

use Roots\Sage\Container;

/**********************************/
/********** FILES HELPER **********/
/**********************************/

final class FilesHelper
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** CHECK IF FILE EXISTS **********/
    /******************************************/

    /**
     * @param String $filename file's name
     * @param Mixed $directory place to check
     * @return Mixed String || Bool
     */

    public static function checkIfFileExists(string $filename, $directory)
    {
        if (is_string($directory)) {
            return self::_checkFile($filename, $directory);
        }

        if (is_array($directory)) {
            foreach($directory as $d => $dir) {
                $filepath = self::_checkFile($filename, $dir);
                if ($filepath) {
                    return $filepath;
                }
            }
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** RETURN FILE'S TOKENS **********/
    /******************************************/

    /**
     * @param String $filepath path to the file
     * @return Mixed Array || Bool
     */

    public static function getFileTokens($filepath)
    {
        if (!empty($filepath)) {
            return token_get_all(file_get_contents($filepath));
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** RETURN FILE'S TOKENS **********/
    /******************************************/

    /**
     * @param Array $tokens token to parse
     * @param Array $check token to look for
     * @return Array
     */
    
    public static function checkTokens(array $tokens, array $check)
    {
        $result = [];
        foreach($tokens as $t => $token) {
            if (!$token || !is_array($token) || empty($token) || empty($token[1])) {
                continue;
            }

            foreach($check as $i => $item) {
                if (in_array($token[1], $check) && !in_array($token[1], $result)) {
                    array_push($result, $token[1]);
                }
            }
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** CHECK FILE **********/
    /********************************/

    /**
     * @param String $filename file's name
     * @param Mixed $directory place to check
     * @return Mixed String || Bool
     */

    private static function _checkFile(string $filename, string $directory)
    {
        if (file_exists(__DIR__ . '/../' . $directory . '/' . $filename . '.php')) {
            return __DIR__ . '/../' . $directory . '/' . $filename . '.php';
        }
        return false;
    }
}