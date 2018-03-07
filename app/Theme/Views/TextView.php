<?php
/**
 * WP System - TextView - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Views;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractView as AbstractView;

/*******************************/
/********** TEXT VIEW **********/
/*******************************/

class TextView extends AbstractView
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
        $altData['content'] = $data['content']['page_builder_rows_cols_col_text'];
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