<?php
/**
 * WP Backend System - Main Widget Register
 *
 * @since       16.08.2017
 * @version     1.0.0.0
 * @author      mlbors
 * @copyright   
 */

namespace App\Theme\Widgets;

use \App\Theme\Posts\PostGetter as PostGetter;

/*********************************************/
/********** MAIN SHORTCODE REGISTER **********/
/*********************************************/

class MainWidgetRegister implements WidgetRegister
{

    /*******************************/
    /********** ATTRIBUTS **********/
    /*******************************/

    /*
     * @var PostGetter $_postGetter object that gets posts
     * @var Array $_widgets array of shortcodes
     */

    private $_postGetter;
    private $_widgets = [];

    /*********************************************************************************/
    /*********************************************************************************/

    /*******************************/
    /********** CONSTRUCT **********/
    /*******************************/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    public function __construct(PostGetter $postGetter)
    {
        $this->_setValues($postGetter);
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
     */

    private function _setValues(PostGetter $postGetter)
    {
        $this->_setPostGetter($postGetter);
    }

    /**********/
    /********** POST GETTER **********/
    /**********/

    /*
     * @param PostGetter $postGetter object that gets posts
     */

    private function _setPostGetter(PostGetter $postGetter)
    {
        $this->_postGetter = $postGetter;
    }

    /**********/
    /********** WIDGETS **********/
    /**********/

    /*
     * @param Array $widgets array of widgets
     */

    private function _setWidgets(array $widgets)
    {
        $this->_widgets = $widgets;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***********************************/
    /********** PARSE WIDGETS **********/
    /***********************************/

    /*
     * @return Mixed Array || false
     */

    private function _parseWidgets()
    {
        $widgets = [];

        $this->_postGetter->setArgs([
                                'posts_per_page'   => -1,
                                'post_type'        => 'acf-field-group',
                            ]);
        $groups = $this->_postGetter->queryPost('get');

        if (empty($groups)|| !is_array($groups) || !$groups) {
            return false;
        }

        foreach ($groups as $group) {

            $groupInfo = maybe_unserialize($group->post_content)['location'][0][0];
            $param = $groupInfo['param'];
            $value = $groupInfo['value'];

            if ($param === 'options_page' && $value === 'acf-options-widgets') {

                $fields = acf_get_fields($group->post_name);

                if (!empty($fields[0]) && is_array($fields[0])) {

                    $repeater = get_field($fields[0]['name'], 'option');

                    if (have_rows($fields[0]['name'], 'option')) {

                        while (have_rows($fields[0]['name'], 'option')) {
                            the_row();
                            $name = get_sub_field('custom_widgets_name', 'option');
                            array_push($widgets, $name);
                        }

                    }

                }

            }

        }

        $this->_setWidgets($widgets);
        return $widgets;
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /******************************/
    /********** REGISTER **********/
    /******************************/

    /*
     * @param String $name widget's name
     */

    public function registerWidget(string $name)
    {
        add_action('widgets_init', function() use ($name) {
            try {
                if (class_exists('\\App\\Theme\\Widgets\\' + $name)) {
                    register_widget($name);
                }
            } catch (\Exception $e) {
                return false;
            }
        });
    }

    /*********************************************************************************/
    /*********************************************************************************/

    /***************************************/
    /********** LOOP OVER WIDGETS **********/
    /***************************************/

    private function _loopOverWidgets()
    {
        if (!empty($this->_widgets) && is_array($this->_widgets)) {
            foreach ($this->_widgets as $widget) {
                $this->registerWidget($widget);
            }
        }   
    }

    /*********************************************************************************/
    /*********************************************************************************/
    
    /************************************/
    /********** SET UP WIDGETS **********/
    /************************************/

    public function setUpWidgets()
    {
        $this->_parseWidgets();
        $this->_loopOverWidgets();
    }

}