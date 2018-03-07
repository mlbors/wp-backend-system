<?php
/**
 * WP System - ACFFieldsHelper - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Helpers;

use Roots\Sage\Container;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;

/***************************************/
/********** ACF FIELDS HELPER **********/
/***************************************/

final class ACFFieldsHelper
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    private function __construct()
    {  
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** PARSE OPTIONS **********/
    /***********************************/

    /**
     * @param String $requestService object that makes requests
     * @param String $optionName targeted option
     * @param Array || String $prefix option's prefix
     * @return Array
     */

    public static function parseOptions(string $requestService, string $optionName, $prefix)
    {
        $groups = self::_getGroupFields($requestService);

        if (!ArraysHelper::checkArray($groups)) {
            return false;
        }

        $array = self::_loopOverGroups($groups, $optionName, $prefix);

        if (!ArraysHelper::checkArray($array)) {
            return false;
        }

        return self::_unfoldArray($array);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** GET GROUP FIELDS **********/
    /**************************************/

    /**
     * @param String $requestService object that makes requests
     * @return Array
     */

    private static function _getGroupFields(string $requestService): Array
    {
        $results = [];
        $groups = $requestService::buildRequestAndExecute([
            'type' => 'post', 
            'action' => 'query'
            ], 
            [
            'method' => '', 
            'method_args' => ['method' => 'get'], 
            'query_args' => ['args' => [
                                'posts_per_page'    =>      -1,
                                'post_type'         =>      'acf-field-group',
                            ]]
            ]);

        foreach($groups as $group) {
            array_push($results, $group->getData());
        }

        return $results;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** LOOP OVER GROUPS **********/
    /**************************************/

    /**
     * @param Array $groups groups of fields
     * @param String $optionName targeted option
     * @param Array || String $prefix option's prefix
     * @return Array
     */

    private static function _loopOverGroups(array $groups, string $optionName, $prefix): array
    {
        $parsedFields = [];

        foreach ($groups as $group) {

            list($param, $value) = self::_getGroupFieldsInfo($group);

            if ($param === 'options_page' && $value === $optionName) {

                $fields = acf_get_fields($group->post_name);

                if (is_array($fields) && count(array_filter($fields)) > 0) {
                    $treatedFields = self::_loopOverFields($fields, $prefix, $group);
                    array_push($parsedFields, $treatedFields);
                }

            }

        }

        return $parsedFields;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************/
    /********** GET GROUP FIELDS INFO **********/
    /*******************************************/

    /**
     * @param Object $group group of fields
     * @return Array
     */

    private static function _getGroupFieldsInfo($group): array
    {
        $groupInfo = maybe_unserialize($group->post_content)['location'][0][0];
        return [$groupInfo['param'], $groupInfo['value']];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**************************************/
    /********** LOOP OVER FIELDS **********/
    /**************************************/

    /**
     * @param Array $fields array of fields
     * @param Array || String $prefix option's prefix
     * @return Array
     */
    private static function _loopOverFields($fields, $prefix, $group): array
    {
        $parsedFields = [];

        foreach ($fields as $f => $field) {

            $value = get_field($field['name']);

            $fieldValues;

            if ($field['type'] === 'repeater') {
                $fieldValues = self::_treatRepeaterField($field, $prefix);
            } else {
                $fieldValues = self::_treatSimpleField($field, $prefix, false);
            }

            array_push($parsedFields, $fieldValues);

        }

        return $parsedFields;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** TREAT REPEATER FIELD **********/
    /******************************************/

    /**
     * @param Array $field extracted field
     * @param Array || String $prefix option's prefix
     * @return Array
     */

    private static function _treatRepeaterField(array $field, $prefix): array
    {
        $data = acf_get_field($field['name']);
        $parsedFields = [];

        if (have_rows($field['name'], 'option')) {

            while (have_rows($field['name'], 'option')) {
                the_row();

                $row = [];
                $repeaterFields = get_row();
                $objectFields = self::_getObjectFields($repeaterFields);

                foreach ($objectFields as $objectField) {
                    $formattedField;

                    if ($objectField['type'] === 'repeater') {
                        $formattedField = self::_treatRepeaterField($objectField, $prefix);
                    } else {
                        $formattedField = self::_treatSimpleField($objectField, $prefix, true);
                    }
                    
                    array_push($row, $formattedField);
                }

                array_push($parsedFields, $row);
            }

        }

        return self::_formatField($field['name'], $parsedFields, $data, $prefix);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** GET OBJECT FIELDS **********/
    /***************************************/

    /**
     * @param Array $repeaterFields fields inside the repeater
     * @return Array
     */

    private static function _getObjectFields(array $repeaterFields): array
    {
        $objectFields = [];

        foreach ($repeaterFields as $f => $repeaterField) {
            $objectField = get_field_object($f);
            $objectFields[$objectField['name']] = $objectField;
        }

        return $objectFields;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** TREAT SIMPLE FIELD **********/
    /****************************************/

    /**
     * @param Array $field extracted field
     * @param Array || String $prefix option's prefix
     * @param Bool $subfield is subfield
     * @return Array
     */

    private static function _treatSimpleField($field, $prefix, $subField = false)
    {
        $value = $subField ? get_sub_field($field['name'], 'option') : get_field($field['name'], 'option');
        $data = acf_get_field($field['name']);

        $formattedField = self::_formatField($field['name'], $value, $data, $prefix);
        return $formattedField;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** FORMAT FIELD **********/
    /**********************************/

    /**
     * @param String $name field's name
     * @param Mixed $value field's value
     * @param Array || String $prefix field's prefix 
     * @return Array
     */

    private static function _formatField(string $name, $value, $data, $prefix): array
    {
        $noPrefixName = self::_removePrefix($name, $prefix);
        $formattedValue = self::_formatArrayValue($value, $prefix);
        return ['name' => $noPrefixName, 'prefixed_name' => $name, 'value' => $formattedValue, 'data' => $data];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** FORMAT ARRAY VALUE **********/
    /****************************************/

    /**
     * @param Mixed $value field's value
     * @param Array || String $prefix field's prefix 
     * @return Mixed
     */

    private static function _formatArrayValue($value, $prefix)
    {
        if (!empty($value) && is_array($value) && count(array_filter(array_keys($value), 'is_string')) > 0) {

            $result = [];

            foreach($value as $v => $val) {

                $index = self::_removePrefix($v, $prefix);
                if (!empty($val) && is_array($val) && count(array_filter(array_keys($val), 'is_string')) > 0) {
                    $result[$index] = self::_formatArrayValue($val, $prefix);
                } elseif (!empty($val) && is_array($val) && !empty($val[0]) && is_array($val[0])) {

                    $sub = [];

                    foreach($val as $i => $item) {
                        $nested = [];
                        foreach($item as $e => $element) {
                            $subindex = self::_removePrefix($e, $prefix);
                            $nested[$subindex] = $element;
                        }

                        $sub[$i] = $nested;
                    }

                    $result[$index] = $sub;

                } else {
                    $result[$index] = $val;
                }
            }   

            return $result;
        }

        return $value;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** REMOVE PREFIX **********/
    /***********************************/

    /**
     * @param String $name field's name
     * @param Array || String $prefix field's prefix 
     * @return String
     */

    private static function _removePrefix(string $name, $prefix): string
    {
        return str_replace($prefix, '', $name);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** UNFOLD ARRAY **********/
    /**********************************/

    /**
     * @param Array $array array to treat
     * @return $array
     */

    private static function _unfoldArray(array $array): array
    {
        list($item, $giantRepeater) = self::_prepareUnfolding($array);
        return self::_loopOverArray($item, $giantRepeater);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** PREPARE UNFOLDING **********/
    /***************************************/

    /**
     * @param Array $array array to treat
     * @return $array
     */

    private static function _prepareUnfolding(array $array): array
    {
        $giantRepeater = false;
        $item = $array[0];

        if (self::_checkIfWholeOptionIsRepeater($array)) {
            $item = $array[0][0]['value'];
            $giantRepeater = true;
        }

        return [$item, $giantRepeater];
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************************************/
    /********** CHECK IF WHOLE OPTION IS REPEATER **********/
    /*******************************************************/

    /**
     * @param Array $array array to treat
     * @return $array
     */

    private static function _checkIfWholeOptionIsRepeater(array $array): bool
    {
        if ($array[0][0]['data']['type'] === 'repeater') {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** LOOP OVER ARRAY **********/
    /*************************************/

    /**
     * @param Array $array array to treat
     * @param Bool $giantRepeater is whole option a unique repeater
     * @return $array
     */

    private static function _loopOverArray(array $array, bool $giantRepeater): array 
    {
        $result = [];

        foreach($array as $v => $value) {
            if (self::_checkIfItIsNotValuesArray($value)) {
                array_push($result, self::_reloopOverArray($value, $giantRepeater));
            } else {
                $result[$value['name']] = self::_treateNestedValues($value, $giantRepeater);
            } 
        }

        return $result;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************************/
    /********** CHECK IF IT IS NOT VALUES ARRAY **********/
    /*****************************************************/

    /**
     * @param Array $value value to treat
     * @return bool
     */

    private static function _checkIfItIsNotValuesArray($value): bool
    {
        if (!empty($value) && is_array($value) && !array_key_exists('value', $value)) {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************************/
    /********** TREATE NESTED VALUES **********/
    /******************************************/

    /**
     * @param Array $value value to treat
     * @param Bool $giantRepeater is whole option a unique repeater
     * @return Mixed
     */

    private static function _treateNestedValues($value, bool $giantRepeater)
    {
        if (self::_checkIfNestedRepeater($value)) {
            return self::_treateNestedRepeater($value, $giantRepeater);
        } else {
            return $value['value'];
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /********************************************/
    /********** TREATE NESTED REPEATER **********/
    /********************************************/

    /**
     * @param Array $value value to treat
     * @param Bool $giantRepeater is whole option a unique repeater
     * @return Mixed
     */

    private static function _treateNestedRepeater($value, bool $giantRepeater)
    {
        if ($giantRepeater) {
            return self::_reloopOverArray($value['value'][0], $giantRepeater);
        }

        return self::_reloopOverArray($value['value'], $giantRepeater);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************************/
    /********** CHECK IF NESTED REPEATER **********/
    /**********************************************/

    /**
     * @param Array $value value to treat
     * @return Mixed
     */

    private static function _checkIfNestedRepeater($value): bool
    {
        if (!empty($value['value'][0]) && is_array($value['value'][0]) && array_key_exists('value', $value['value'][0][0])) {
            return true;
        }

        return false;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** RELOOP OVER ARRAY **********/
    /***************************************/

    /**
     * @param Array $value value to treat
     * @param Bool $giantRepeater is whole option a unique repeater
     * @return Mixed
     */

    private static function _reloopOverArray($value, bool $giantRepeater)
    {
        return self::_loopOverArray($value, $giantRepeater);
    }
}