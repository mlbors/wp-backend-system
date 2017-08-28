<?php
/**
 * WP Backend System - Builder - Interface
 *
 * @since       02.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Themes;

/*****************************/
/********** BUILDER **********/
/*****************************/

interface Builder
{
    public function build(): Theme;
}