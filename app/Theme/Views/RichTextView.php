<?php
/**
 * WP System - RichTextView - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Views;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractView as AbstractView;

/************************************/
/********** RICH TEXT VIEW **********/
/************************************/

class RichTextView extends AbstractView
{
    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param String $file file to use
     */

    public function __construct(string $file)
    {
        parent::__construct($file);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** RENDER **********/
    /****************************/

    public function render()
    {
        $this->_preprocessData();
        return $this->_renderView();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*************************************/
    /********** PREPROCESS DATA **********/
    /*************************************/

    protected function _preprocessData()
    {
        $content = do_shortcode($this->_data['content']);
        $this->_data['content'] = $content;
    }
}