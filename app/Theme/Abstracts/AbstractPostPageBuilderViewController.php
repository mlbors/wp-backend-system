<?php
/**
 * WP System - AbstractPostPageBuilderViewController - Abstract Class
 *
 * @since       12.01.2018
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Abstracts;

use Roots\Sage\Container;

use App\Theme\Interfaces\IViewFactory as IViewFactory;
use App\Theme\Interfaces\IViewControllerPageBuilder as IViewControllerPageBuilder;

/****************************************************************/
/********** ABSTRACT POST PAGE BUILDER VIEW CONTROLLER **********/
/****************************************************************/

abstract class AbstractPostPageBuilderViewController extends AbstractViewController implements IViewControllerPageBuilder
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

    /**
     * @param IViewFactory $viewFactory object that creates views
     */

    public function __construct(IViewFactory $viewFactory)
    {
        parent::__construct($viewFactory);
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

    /***********************************/
    /********** SET VIEW TYPE **********/
    /***********************************/

    /**
     * @param String $type view type
     */

    protected function _setViewType()
    {
        $this->_viewFactory->setType($this->_type);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /************************************/
    /********** INIT VIEW VIEW **********/
    /************************************/

    /**
     * @param String $type view type
     * @param Mixed $data view's data
     */

    public function initView(string $type, $data)
    {
        $this->setType($type);
        $this->_setViewType();
        $this->_instantiateView();
        $this->_setViewData($data);
    }
}