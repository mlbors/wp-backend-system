<?php
/**
 * WP System - PageBuilderViewFactory - Concrete Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IView as IView;
use App\Theme\Abstracts\AbstractViewFactory as AbstractViewFactory;
use App\Theme\Views\ColView as ColView;
use App\Theme\Views\RichTextView as RichTextView;
use App\Theme\Views\RowView as RowView;
use App\Theme\Views\SectionView as SectionView;
use App\Theme\Views\TextView as TextView;

/**********************************/
/********** VIEW FACTORY **********/
/**********************************/

class PageBuilderViewFactory extends AbstractViewFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var String $_type view type
     */

    protected $_type;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    public function __construct()
    {
        parent::__construct();
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** SET TYPE **********/
    /******************************/

    public function setType(string $type)
    {
        $this->_type = $type;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*********************************/
    /********** CREATE VIEW **********/
    /*********************************/

    /**
     * @return IView
     */

    protected function _createView(): IView
    {
        switch($this->_type) {
            case 'col':
                return $this->_container->makeWith(ColView::class, ['file' => 'col']);
                break;
            case 'row':
                return $this->_container->makeWith(RowView::class, ['file' => 'row']);
                break;
            case 'section':
                return $this->_container->makeWith(SectionView::class, ['file' => 'section']);
                break;
            case 'text':
                return $this->_container->makeWith(TextView::class, ['file' => 'text']);
                break;
            case 'rich_text':
                return $this->_container->makeWith(RichTextView::class, ['file' => 'rich-text']);
                break;
            default:
                return $this->_container->makeWith(TextView::class, ['file' => 'text']);
                break;
        }
    }
}