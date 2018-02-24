<?php

namespace App;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public static function globals()
    {
        global $settings;
        return print_r($settings, true);
    }
}
