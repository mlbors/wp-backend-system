<?php
/**
 * WP Backend System - Transient Operator - Interface
 *
 * @since       15.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Transients;

/****************************************/
/********** TRANSIENT OPERATOR **********/
/****************************************/

interface TransientOperator
{
    public function operate(string $name, int $lifetime = 5);
    public function initTransient(string $name, int $lifetime, $data);
}