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

    /*********************************************/
    /********** CREATE FILE USING CACHE **********/
    /*********************************************/

    /**
     * @param String $filename file's name
     * @param Mixed $directory place to check
     * @param String $content file content
     * @param Int $minutes
     * @return Mixed
     */

    public static function createFileUsingCache(string $filename, string $directory, string $content, int $minutes)
    {
        $file = '';
        if (self::_checkFile($filename, $directory)) {
            $file = self:: _checkFileLiftime($filename, $directory, $minutes);
            if ($file) {
                return $file;
            }
        }

        return self::createFile($filename, $directory, $content);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** CREATE FILE **********/
    /*********************************/

    /**
     * @param String $filename file's name
     * @param Mixed $directory place to check
     * @param String $content file content
     * @return Mixed
     */

    public static function createFile(string $filename, string $directory, string $content)
    {
        if (empty($content)) {
            return false;
        }

        $path = __DIR__ . '/../' . $directory . '/' . $filename;

        if (self::_checkFile($filename, $directory)) {
            unlink($path);
        }

        return file_put_contents($path, $content);
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
        if (file_exists(__DIR__ . '/../' . $directory . '/' . $filename)) {
            return __DIR__ . '/../' . $directory . '/' . $filename;
        }
        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CHECK FILE LIFTIME **********/
    /****************************************/

    /**
     * @param String $filename file's name
     * @param Mixed $directory place to check
     * @param Int $minutes
     * @return Mixed String || Bool
     */

    private static function _checkFileLiftime(string $filename, string $directory, int $minutes)
    {
        $file = __DIR__ . '/../' . $directory . '/' . $filename;
        if (filemtime($file) > (time() - 60 * 5 )) {
            return file_get_contents($file);
        }
        return false;
    }
}