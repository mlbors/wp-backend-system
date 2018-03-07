<?php
/**
 * WP System - FrontViewFactory - Concrete Class
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
use App\Theme\Views\FrontView as FrontView;

/**********************************/
/********** VIEW FACTORY **********/
/**********************************/

class FrontViewFactory extends AbstractViewFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var String $_directory targeted directory
     * @var String $_type view type
     */

    protected $_directory;
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

    /***********************************/
    /********** SET DIRECTORY **********/
    /***********************************/

    public function setDirectory(string $directory)
    {
        $this->_directory = $directory;
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
        return $this->_container->makeWith(FrontView::class, ['file' => $this->_directory . '/' . $this->_type]);
    }
}