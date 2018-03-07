<?php
/**
 * WP System - ButtonView - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Views;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractView as AbstractView;

/*********************************/
/********** BUTTON VIEW **********/
/*********************************/

class ButtonView extends AbstractView
{
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

    /******************************/
    /********** SET DATA **********/
    /******************************/

    /**
     * @param Mixed $data view's data
     */

    public function setData($data)
    {
        $altData = $data;
        $altData['url'] = $data['content']['page_builder_rows_cols_col_button'];
        $altData['content'] = $data['content']['page_builder_rows_cols_col_button_content'];
        $altData['target'] = $data['content']['page_builder_rows_cols_col_button_target'];
        $altData['title'] = $data['content']['page_builder_rows_cols_col_button_title'];
        parent::setData($altData);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************/
    /********** RENDER **********/
    /****************************/

    public function render()
    {
        return $this->_renderView();
    }
}