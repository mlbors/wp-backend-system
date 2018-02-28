<?php
/**
 * WP System - GalleryView - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Views;

use Roots\Sage\Container;

use App\Theme\Abstracts\AbstractView as AbstractView;

/**********************************/
/********** GALLERY VIEW **********/
/**********************************/

class GalleryView extends AbstractView
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
        $altData['images'] = [];

        $cpt = 0;

        foreach($data['content']['page_builder_rows_cols_col_gallery'] as $i => $image) {
            $altData['images'][$cpt]['thumbnail'] = $image['sizes']['thumbnail'];
            $altData['images'][$cpt]['url'] = $image['url'];
            $altData['images'][$cpt]['description'] = $image['description'];
            $altData['images'][$cpt]['caption'] = $image['caption'];
            $altData['images'][$cpt]['name'] = $image['alt'];

            $cpt++;
        }

        $altData['action'] = $data['content']['page_builder_rows_cols_col_gallery_action'];
        $altData['target'] = !empty($data['content']['page_builder_rows_cols_col_gallery_action']) ? $data['content']['page_builder_rows_cols_col_gallery_target'] : '';
        $altData['items_per_row'] = $data['content']['page_builder_rows_cols_col_items_per_row'];
        $altData['col_size'] = 12/$altData['items_per_row'];

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