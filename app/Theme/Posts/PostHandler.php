<?php
/**
 * WP Backend System - Post Handler
 *
 * @since       03.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Posts;

/**********************************/
/********** POST HANDLER **********/
/**********************************/

class PostHandler implements Handler
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var PostGetter $postGetter object that gets posts
     * @var PostCreator $customPostCreator object that creates CPT
     */

    private $_postGetter;
    private $_customPostCreator;

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param PostGetter $postGetter object that gets posts
     * @param PostCreator $customPostCreator object that creates CPT
     */

    public function __construct(PostGetter $postGetter, PostCreator $customPostCreator)
    {
        $this->_setValues($postGetter, $customPostCreator);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SETTERS **********/
    /*****************************/

    /**********/
    /********** SET VALUES **********/
    /**********/

    /*
     * @param PostGetter $postGetter object that gets posts
     * @param PostCreator $customPostCreator object that creates CPT
     */

    private function _setValues(PostGetter $postGetter, PostCreator $customPostCreator)
    {
        $this->setPostGetter($postGetter);
        $this->setCustomPostCreator($customPostCreator);
    }

    /**********/
    /********** POST GETTER **********/
    /**********/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    public function setPostGetter(PostGetter $postGetter)
    {
        $this->_postGetter = $postGetter;
    }

    /**********/
    /********** CUSTOM POST CREATOR **********/
    /**********/

    /*
     * @param PostCreator $customPostCreator object that creates CPT
     */

    public function setCustomPostCreator(PostCreator $customPostCreator)
    {
        $this->_customPostCreator = $customPostCreator;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** GETTERS **********/
    /*****************************/

    /**********/
    /********** POST GETTER **********/
    /**********/

    /*
     * @return PostGetter
     */

    public function getPostGetter(): PostGetter
    {
        return $this->_postGetter;
    }

    /**********/
    /********** CUSTOM POST CREATOR **********/
    /**********/

    /*
     * @return PostCreator
     */

    public function getPostCreator(): PostCreator
    {
        return $this->_customPostCreator;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** SET CPT **********/
    /*****************************/

    public function setCPT()
    {
        try {
            $this->_customPostCreator->setCPT();
        } catch (\Exception $e) {
            return false;
        }
    }
}