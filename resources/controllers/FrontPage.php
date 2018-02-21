<?php

namespace App;

use Sober\Controller\Controller;

class FrontPage extends Controller
{

    /**
     * @return object
     */
    
    /*
    protected function _generateSections(Int $id)
    {
        return $post = get_post($id, OBJECT, 'display');
    }
    */

    /**
     * @return array
     */

    /* 
    protected function _retrieveSections()
    {
        $array = array();

        if (have_rows('homepage_sections')) {

            $i = 0;

            while (have_rows('homepage_sections')) {

                the_row();
                $array[$i] = self::_generateSections(get_sub_field('homepage_sections_page'));
                $i++;

            }

        }

        return $array;
    }
    */

    /**
     * @return array
     */

    /*
    public function sections()
    {
        return self::_retrieveSections();
    }
    */

    public static function globals()
    {
        global $settings;
        return print_r($settings, true);
    }

}
