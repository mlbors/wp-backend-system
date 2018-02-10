# WordPress System #

A WordPress admin system built with [Sage](https://github.com/roots/sage) and [ACF Pro](https://www.advancedcustomfields.com/pro/) to create and manage Custom Post Types, Custom Taxonomies, Shortcodes and more. It is like a WordPress Theme Builder/Customizer.

## About ##

This system is based on [Sage](https://github.com/roots/sage) and [ACF Pro](https://www.advancedcustomfields.com/pro/) that is not included in this project.

The main purpose of this project is to build a simple system that let the users manage WordPress functionalities and add some new ones. This system is not perfect and it is not finished.

## Status ##

In progress.

## Features ##

* Create Custom Post Types
* Create Custom Taxonomies
* Generate Shortcodes (Posts list, Single Post, Text, Image, Image Gallery, Specific view)
* Use Transients with Shortcodes and manage cache
* Create User Roles
* Manage menus visibility
* Add Query Args
* Manage redirections
* Add theme options on the fly with [ACF Pro](https://www.advancedcustomfields.com/pro/)
* Access to global informations, like theme settings, current user, etc.

## To-Do ##

* Fix bugs
* Refactor if necesseray
* Improve architecture
* Write good and useful tests
* Add functionalities
* Find a solution for Widgets
* Offer a way to decouple it from [Sage](https://github.com/roots/sage)
* Offer a way to extend it

## About the structure ##

Basically, the system works like so: a Theme object, ITheme, acts like a Main. It will ask an Initializer object, which implements the IInitializer interface, to, obviously, initialize the whole thing. The Initializer will ask a SideFacade, which implements the ISideFacade interface, to execute the required operations and to send back settings data that will be available globally. An ISide object is then created, depending on the displayed part of WordPress, the website itself or the WP Admin part. A Side object has several IManager objects that will setup a bunch of IHandlers object. Each Handler object is completely independent of the others and doesn’t know them. Every Handler is assigned to a specific task and for that has a IRepository object. Requests are performed through a Request Service. When a request is executed, it will ask the Manager object, that it has in reference, to dispatch the request. The Manager will then ask every initialized Handler if it can handle the request. If it can, it will then perform the operation through its Repository. This last one will get the data through a IContext object before putting it into an IEntity object that will be encapsulated in a IThemeObject object. Even if they share the same interface, every ThemeObject has its own attributes and methods. Some ThemeObject objects also have a State, implementing the IState interface, that defines the behaviour they must adopt when they are called. Each Shortcode object, for example, has its own specific behaviour depending of its type. A IShortcode object has also access to the TransientService that manages transients.

For now, because this project is based on [Sage](https://github.com/roots/sage), it uses Blade as a template engine and the Illuminate Contaner for Dependency Injection.

## Usage ##

Here a few things about how to use this system.

### CPT, CT, Shortcodes, Options, etc. ###

Just set up the whole thing, hope there is no bug and go to WP Admin. A Settings menu should be here.

### Global Settings ###

Some settins are available through a global settings variable. It can be called like so:

    global $settings

A reference to the Service Request is available through this variable.

### Service request ###

Down below, a few examples of how to use the Request Service.

Querying Posts

    $posts = $this->_requestService::buildRequestAndExecute([
                  'type' => 'post', 
                  'action' => 'query'
                  ], 
                  [
                  'method' => '', 
                  'method_args' => ['method' => ''], 
                  'query_args' => ['args' => $args]
                  ]);

    $result = $posts->getData();

Querying a specifc Post

    $this->_requestService::buildRequestAndExecute([
            'type' => 'post', 
            'action' => 'query'
            ], 
            [
            'method' => 'ByID', 
            'method_args' => [], 
            'query_args' => ['ID' => 5]
            ]);

Querying taxonomies

    $this->_requestService::buildRequestAndExecute([
            'type' => 'taxonomy', 
            'action' => 'query'
            ], 
            [
            'method' => '', 
            'method_args' => ['output' => 'objects', 'operator' => 'and'], 
            'query_args' => ['args' => []]
            ]);

## Requirements ##

* [WordPress](https://wordpress.org/) >= 4.7
* [PHP](http://php.net/manual/en/install.php) >= 5.6.4
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 6.9.x
* [Yarn](https://yarnpkg.com/en/docs/install)
* [ACF Pro](https://www.advancedcustomfields.com/pro/)
* [Sage](https://github.com/roots/sage)

## Why Sage? ##

Because [Sage](https://github.com/roots/sage) is really awesome and all the people that supports this project make a fantastic work. This system is DRY and allows to manage the structure of a custom WordPress theme easily and elegantly.

## Why ACF Pro? ##

Because it is uncessary to reinvent the wheel. [ACF Pro](https://www.advancedcustomfields.com/pro/) is a really powerfull tool that allows to add fields to WordPress very easily.