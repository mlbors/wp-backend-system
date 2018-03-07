<?php
/**
 * WP System - ShortcodeStateFactory - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\Factories;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractStateFactory as AbstractStateFactory;
use App\Theme\States\ShortcodePostsState as ShortcodePostsState;
use App\Theme\States\ShortcodePostState as ShortcodePostState;
use App\Theme\States\ShortcodeTextState as ShortcodeTextState;
use App\Theme\States\ShortcodeViewState as ShortcodeViewState;
use App\Theme\States\ShortcodeImageState as ShortcodeImageState;
use App\Theme\States\ShortcodeGalleryState as ShortcodeGalleryState;
use App\Theme\States\ShortcodeStandardState as ShortcodeStandardState;

/*********************************************/
/********** SHORTCODE STATE FACTORY **********/
/*********************************************/

class ShortcodeStateFactory extends AbstractStateFactory
{
    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /**
     * @var String $_transientService object that manages transients (static class)
     * @var String $_requestService object that manages requests (static class)
     */

    protected $_transientService;
    protected $_requestService;

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
    
    /*******************************************/
    /********** SET TRANSIENT SERVICE **********/
    /*******************************************/

    /**
     * @param String $transientService object that manages transients (static class)
     */

    public function setTransientService($transientService)
    {
        $this->_transientService = $transientService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************************/
    /********** SET REQUEST SERVICE **********/
    /*****************************************/

    /**
     * @param String $requestService object that manages requests (static class)
     */

    public function setRequestService(string $requestService)
    {
        $this->_requestService = $requestService;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /**********************************/
    /********** CREATE STATE **********/
    /**********************************/

    /**
     * @param String $state targeted $state
     * @param IEntity $entity redirection entity
     * @return IState
     */

    protected function _createState(string $state, IEntity $entity): IState
    {
        switch($state) {
            case 'posts':
                return $this->_container->makeWith(ShortcodePostsState::class, ['entity' => $entity, 'transientService' => $this->_transientService, 'requestService' => $this->_requestService]);
                break;
            case 'post':
                return $this->_container->makeWith(ShortcodePostState::class, ['entity' => $entity, 'transientService' => $this->_transientService, 'requestService' => $this->_requestService]);
                break;
            case 'text':
                return $this->_container->makeWith(ShortcodeTextState::class, ['entity' => $entity, 'transientService' => $this->_transientService, 'requestService' => $this->_requestService]);
                break;
            case 'view':
                return $this->_container->makeWith(ShortcodeViewState::class, ['entity' => $entity, 'transientService' => $this->_transientService, 'requestService' => $this->_requestService]);
                break;
            case 'image':
                return $this->_container->makeWith(ShortcodeImageState::class, ['entity' => $entity, 'transientService' => $this->_transientService, 'requestService' => $this->_requestService]);
                break;
            case 'gallery':
                return $this->_container->makeWith(ShortcodeGalleryState::class, ['entity' => $entity, 'transientService' => $this->_transientService, 'requestService' => $this->_requestService]);
                break;
            default:
                return $this->_container->makeWith(ShortcodeStandardState::class, ['entity' => $entity, 'transientService' => $this->_transientService, 'requestService' => $this->_requestService]);
                break;
        }
        
    }
}