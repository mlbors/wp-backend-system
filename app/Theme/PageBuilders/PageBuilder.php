<?php
/**
 * WP System - PageBuilder - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\PageBuilders;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewControllerFactory as IViewControllerFactory;
use App\Theme\Abstracts\AbstractPageBuilder as AbstractPageBuilder;
use App\Theme\Helpers\ArraysHelper as ArraysHelper;

/**********************************/
/********** PAGE BUILDER **********/
/**********************************/

class PageBuilder extends AbstractPageBuilder
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IViewController $viewController view controller object
     */

    public function __construct(IViewControllerFactory $viewControllerFactory)
    {
        parent::__construct($viewControllerFactory);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************/
    /********** BUILD **********/
    /***************************/

    /**
     * @return string
     */

    public function build()
    {
        return $this->_generateView();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** GENRATE VIEW **********/
    /**********************************/

    /**
     * @return string
     */

    protected function _generateView(): string
    {
        $rows = $this->_loopOverRows();
        return implode('', $rows);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** LOOP OVER ROWS **********/
    /************************************/

    /**
     * @return array
     */

    protected function _loopOverRows(): array
    {
        $rowViews = [];

        foreach($this->_rows as $r => $row) {
            $colViews = [];
            $cols = $row['page_builder_rows_cols'];

            if (!ArraysHelper::checkArray($cols)) {
                continue;
            }

            $colViews = $this->_loopOverCols($cols);
            $rowView = $this->_createRowWrapper($row, $colViews);

            if ($row['page_builder_rows_row_section']) {
                $rowViews[] = $this->_createSection($row, $rowView);
            } else {
                $rowViews[] = $rowView;
            }

        }

        return $rowViews;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** LOOP OVER COLS **********/
    /************************************/

    /**
     * @return array
     */

    protected function _loopOverCols(array $cols): array
    {
        $colViews = [];
        $nbCols = count($cols);

        foreach($cols as $c => $col) {
            $colContent = $this->_createColContent($col);
            $colViews[] = $this->_createColWrapper($col, $colContent, $nbCols);
        }

        return $colViews;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CREATE COL CONTENT **********/
    /****************************************/

    /**
     * @param Array $col column information
     * @return string
     */

    protected function _createColContent(array $col): string
    {
        $type = $col['page_builder_rows_cols_col_type'];
        $data = [];
        $data['content'] = $col['page_builder_rows_cols_col_text'];
        $this->_viewController->initView($type, $data);
        return $this->_viewController->display();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CREATE COL WRAPPER **********/
    /****************************************/

    /**
     * @param Array $col column information
     * @param string $content column content
     * @param int $nbCols number of column
     * @return string
     */

    protected function _createColWrapper(array $col, string $content, int $nbCols): string
    {
        $data = [];
        $data['col_size'] = !empty($col['page_builder_rows_cols_col_size']) ? $col['page_builder_rows_cols_col_size'] : 12/$nbCols;
        $data['classes'] = $col['page_builder_rows_cols_col_classes'];
        $data['style'] = $col['page_builder_rows_cols_col_style'];
        $data['content'] = $content;
        
        $this->_viewController->initView('col', $data);
        return $this->_viewController->display();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /****************************************/
    /********** CREATE ROW WRAPPER **********/
    /****************************************/

    /** 
     * @param Array $row row information
     * @param Array $cols generated columns
     * @return string
     */

    protected function _createRowWrapper(array $row, array $cols): string
    {
        $data = [];
        $data['content'] = implode('', $cols);
        $data['style'] = $row['page_builder_rows_row_style'];
        $data['classes'] = $row['page_builder_rows_classes'];
        $this->_viewController->initView('row', $data);
        return $this->_viewController->display();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** CREATE SECTION **********/
    /************************************/

    /** 
     * @param Array $row row information
     * @param Array $content row content
     * @return string
     */

    protected function _createSection(array $row, string $content): string
    {
        $data = [];
        $data['content'] = $content;
        $data['container'] = $row['page_builder_rows_row_section_container'];
        $data['style'] = $row['page_builder_rows_row_section_style'];
        $data['classes'] = $row['page_builder_rows_row_section_classes'];
        $this->_viewController->initView('section', $data);
        return $this->_viewController->display();
    }
}