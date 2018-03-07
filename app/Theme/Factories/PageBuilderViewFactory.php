<?php
/**
 * WP System - PageBuilderViewFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IView as IView;
use App\Theme\Abstracts\AbstractViewFactory as AbstractViewFactory;
use App\Theme\Views\ButtonView as ButtonView;
use App\Theme\Views\ColView as ColView;
use App\Theme\Views\GalleryView as GalleryView;
use App\Theme\Views\ImageView as ImageView;
use App\Theme\Views\LinkView as LinkView;
use App\Theme\Views\MetaView as MetaView;
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
        $directory = 'builder-views/';
        switch($this->_type) {
            case 'button':
                return $this->_container->makeWith(ButtonView::class, ['file' => $directory . 'button']);
                break;
            case 'col':
                return $this->_container->makeWith(ColView::class, ['file' => $directory . 'col']);
                break;
            case 'gallery':
                return $this->_container->makeWith(GalleryView::class, ['file' => $directory . 'gallery']);
                break;
            case 'image':
                return $this->_container->makeWith(ImageView::class, ['file' => $directory . 'image']);
                break;
            case 'link':
                return $this->_container->makeWith(LinkView::class, ['file' => $directory . 'link']);
                break;
            case 'meta':
                return $this->_container->makeWith(MetaView::class, ['file' => $directory . 'meta']);
                break;
            case 'row':
                return $this->_container->makeWith(RowView::class, ['file' => $directory . 'row']);
                break;
            case 'rich_text':
                return $this->_container->makeWith(RichTextView::class, ['file' => $directory . 'rich-text']);
                break;
            case 'section':
                return $this->_container->makeWith(SectionView::class, ['file' => $directory . 'section']);
                break;
            case 'text':
                return $this->_container->makeWith(TextView::class, ['file' => $directory . 'text']);
                break;
            default:
                return $this->_container->makeWith(TextView::class, ['file' => $directory . 'text']);
                break;
        }
    }
}