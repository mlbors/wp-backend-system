<?php
/**
 * WP System - ShortcodeGalleryState - Concrete Class
 *
 * @since       2018.01.12
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright
 */

namespace App\Theme\States;

use Roots\Sage\Container;

use App\Theme\Interfaces\IEntity as IEntity;
use App\Theme\Interfaces\IState as IState;
use App\Theme\Abstracts\AbstractShortcodeState as AbstractShortcodeState;

/*********************************************/
/********** SHORTCODE GALLERY STATE **********/
/*********************************************/

class ShortcodeGalleryState extends AbstractShortcodeState
{
    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /**
     * @param IEntity $entity entity object
     * @param String $transientService object that manages transients (static class)
     * @param String $requestService object that manages requests (static class)
     */

    public function __construct(IEntity $entity, string $transientService, string $requestService)
    {
        parent::__construct($entity, $transientService, $requestService);
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** EXECUTE QUERY **********/
    /***********************************/

    /**
     * @param Array $data shortcode's data
     * @return Mixed
     */

    protected function _executeQuery()
    {
        try {
            $result = [];

            foreach($this->_data['images'] as $i => $image) {
                $result[$i]['image_data'] = wp_get_attachment_metadata($image['ID'], false);
                $result[$i]['image_data']['full_path'] = wp_get_attachment_image_src($image['ID'], 'full')[0];
                foreach ($image['sizes'] as $s => $sizes) {
                    $result[$i]['image_data']['sizes'][$s]['full_path'] = wp_get_attachment_image_src($image['ID'], $s)[0];
                }
            }

            $this->_setResult($result);
            return $this->_result;

        } catch (\Exception $e) {
            return $this->_result;
        }
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /*****************************/
    /********** EXECUTE **********/
    /*****************************/

    public function execute()
    {
        $this->_setData($this->_entity->display_gallery);
        $this->_registerShortcode();
    }
}