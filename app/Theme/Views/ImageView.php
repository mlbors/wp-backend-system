<?php
/**
 * WP System - ImageView - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Views;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractView as AbstractView;

/********************************/
/********** IMAGE VIEW **********/
/********************************/

class ImageView extends AbstractView
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
        $altData['content'] = [];
        $altData['url'] = $data['content']['page_builder_rows_cols_col_image']['url'];
        $altData['description'] = $data['content']['page_builder_rows_cols_col_image']['description'];
        $altData['caption'] = $data['content']['page_builder_rows_cols_col_image']['caption'];
        $altData['name'] = $data['content']['page_builder_rows_cols_col_image']['name'];
        $altData['action'] = $data['content']['page_builder_rows_cols_col_image_action'];
        $altData['link'] = $data['content']['page_builder_rows_cols_col_image_link'];
        $altData['target'] = !empty($data['content']['page_builder_rows_cols_col_image_action']) ? $data['content']['page_builder_rows_cols_col_image_action_target'] : '';
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