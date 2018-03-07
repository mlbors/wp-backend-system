<?php
/**
 * WP System - CSSGenerator - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Generators;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractGenerator as AbstractGenerator;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;
use App\Theme\Helpers\EnqueuerHelper as EnqueuerHelper;
use App\Theme\Helpers\FilesHelper as FilesHelper;

/***********************************/
/********** CSS GENERATOR **********/
/***********************************/

class CSSGenerator extends AbstractGenerator
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var Array $_dictionary contains special keys
     * @var Array $_globals global variables
     * @var Array $_units units to use
     * @var Array $_fallbacks array of fallback values
     * @var Array $_values css values
     */

    protected $_dictionary = [];
    protected $_globals = [];
    protected $_units = [];
    protected $_fallbacks = [];
    protected $_values = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
        $this->_setGeneratorValues();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** SET GENERATOR VALUES **********/
    /******************************************/

    protected function _setGeneratorValues()
    {
        $this->_setDictionary();
        $this->_setGlobals();
        $this->_setUnits();
        $this->_setFallbacks();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** SET DICTIONARY **********/
    /************************************/

    protected function _setDictionary()
    {
        $this->_dictionary = [
            'headings'      =>      'h1,h2,h3,h4,h5,h6',
            'apseudo1'      =>      'a,a:link,a:visited',
            'apseudo2'      =>      'a:hover,a:active,a:focus' 
        ];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** SET GLOBALS **********/
    /*********************************/

    protected function _setGlobals()
    {
        $this->_globals = [
            'primary'        =>      '',
            'secondary'      =>      '',
        ];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** SET UNITS **********/
    /*******************************/

    protected function _setUnits()
    {
        $this->_units = [
            'font-size'     =>      'px',
            'margin'        =>      'px',
            'padding'       =>      'px',
            'top'           =>      'px',
            'left'          =>      'px',
            'bottom'        =>      'px',
            'right'         =>      'px'
        ];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** SET FALLBACKS **********/
    /***********************************/

    protected function _setFallbacks()
    {
        $this->_fallbacks = [
            'headings'      =>      [
                                        'color'     =>      $this->_globals['primary']
                                    ],
            'apseudo1'      =>      [
                                        'color'     =>      $this->_globals['primary']
                                    ],
            'apseudo2'      =>      [
                                        'color'     =>      $this->_globals['secondary']
                                    ]
        ];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** SET GLOBAL **********/
    /********************************/

    /**
     * @param String $key array key
     * @param Mixed $value to store
     */

    protected function _setGlobal($key, $value)
    {
        $this->_globals[$key] = $value;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************/
    /********** GET VALUES **********/
    /********************************/

    /**
     * @return Array
     */

    public function getValues(): array
    {
        return $this->_values;
    }
    
    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** PARSE KEY **********/
    /*******************************/

    /**
     * @param String $key key to parse
     * @return Array
     */

    protected function _parseKey(string $key): array
    {   
        $exploded = explode('_', $key);
        $tag = $exploded[0];
        unset($exploded[0]);
        $property = implode('-', $exploded);
        return array($tag, $property);
    }   

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** CHECK IF GLOBAL **********/
    /*************************************/

    /**
     * @param String $key key to check
     * @return Bool
     */

    protected function _checkIfGlobal(string $key): bool
    {
        return array_key_exists($key, $this->_globals);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** CHECK IF SPECIAL **********/
    /**************************************/

    /**
     * @param String $key key to check
     * @return Bool
     */

    protected function _checkIfSpecial(string $key): bool
    {
        return array_key_exists($key, $this->_dictionary);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** PREPARE VALUE **********/
    /***********************************/

    /**
     * @param String $key array key
     * @param String $property css property
     * @param Mixed $value value to prepare
     * @return Mixed
     */

    protected function _prepareValue(string $key, string $property, $value)
    {
        if (empty($value) && !empty($this->_fallbacks[$key]) && !empty($this->_fallbacks[$key][$property])) {
            return $this->_fallbacks[$key][$property];
        }

        if (empty($value)) {
            return false;
        }

        $preparedValue = trim($value);

        if (!empty($this->_units[$property])) {
            if (strpos($preparedValue, $this->_units[$property]) === false) {
                $preparedValue = $preparedValue . $this->_units[$property];
            }
        }

        return $preparedValue;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** WRITE CSS PROPERTIES **********/
    /******************************************/

    /**
     * @param Array $properties css properties
     * @return String
     */

    protected function _writeProperties(array $properties): string
    {
        $str = '';

        foreach($properties as $p => $property) {
            if (!empty($property['property']) && !empty($property['value'])) {
                $str .= $property['property'] . ':' . $property['value'] . ';';
            }
        }

        return $str;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** WRITE CSS **********/
    /*******************************/

    /**
     * @return String
     */

    protected function _writeCss(): string
    {
        $str = '';

        foreach($this->_values as $v => $value) {
            $str .= $value['tag'] . '{';
            $str .= $this->_writeProperties($value['properties']);
            $str .= '}';
        }
        
        return $str;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** STORE CSS VALUE **********/
    /*************************************/

    /**
     * @param String $key array key
     * @param String $tag css tag
     * @param String $property css property
     * @param Mixed $value css value
     */

    protected function _storeCssValue(string $key, string $tag, string $property, $value)
    {
        if (empty($this->_values[$key]) || !ArraysHelper::checkArray($this->_values[$key])) {
            $this->_values[$key] = [];
            $this->_values[$key]['tag'] = $tag;
            $this->_values[$key]['properties'] = [];
        }

        $preparedValue = $this->_prepareValue($key, $property, $value);
        array_push($this->_values[$key]['properties'], ['property' => $property, 'value' => $preparedValue]);
    }

    
    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** PREPARE GLOBALS **********/
    /*************************************/

    protected function _prepareGlobals()
    {
        foreach($this->_data as $i => $item) {
            if (empty($item) || empty($item->type)) {
                continue;
            }
            list($tag, $property) = $this->_parseKey($item->type);
            if ($this->_checkIfGlobal($tag)) {
                $this->_setGlobal($tag, $item->value);
                continue;
            }
        }

        $this->_setFallbacks();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** PROCESS VALUES *********/
    /***********************************/

    protected function _processValues()
    {
        foreach($this->_data as $i => $item) {
            if (empty($item) || empty($item->type)) {
                continue;
            }

            list($tag, $property) = $this->_parseKey($item->type);

            if ($this->_checkIfGlobal($tag)) {
                continue;
            }

            $key = $tag;

            if ($this->_checkIfSpecial($tag)) {
                $tag = $this->_dictionary[$tag];
            }

            $this->_storeCssValue($key, $tag, $property, $item->value);
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** PROCESS DATA **********/
    /**********************************/

    /**
     * @return Mixed
     */

    protected function _processData()
    {
        if (!ArraysHelper::checkArray($this->_data)) {
            return false;
        }

        $this->_prepareGlobals();
        $this->_processValues();

        $result = $this->_writeCss();
        $this->_setResult($result);
        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** GENERATE **********/
    /******************************/

    public function generate()
    {
        $this->_processData();
        $filename = 'generated-css';
        $file = '';

        if (!empty($this->_result)) {
            $file = FilesHelper::createFileUsingCache($filename . '.css', '../../dist/styles/', $this->_result, 5);
        }
        
        if ($file) {
            EnqueuerHelper::enqueueStyle($filename, get_stylesheet_directory_uri() . '/../dist/styles/' . $filename . '.css', ['sage/main.css'], false, 'all');
        }
    }
}