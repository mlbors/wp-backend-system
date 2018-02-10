# WordPress System #

A WordPress admin system built with [Sage](https://github.com/roots/sage) and [ACF Pro](https://www.advancedcustomfields.com/pro/) to create and manage _Custom Post Types_, _Custom Taxonomies_, _Shortcodes_ and more. It is like a _WordPress Theme Builder/Customizer_.

## About ##

This system is based on [Sage](https://github.com/roots/sage) and [ACF Pro](https://www.advancedcustomfields.com/pro/) that is not included in this project.

The main purpose of this project is to build a simple system that let the users manage _WordPress_ functionalities and add some new ones. This system is not perfect and it is not finished.

## Status ##

In progress.

## Features ##

* Create _Custom Post Types_
* Create _Custom Taxonomies_
* Generate _Shortcodes_ (Posts list, Single Post, Text, Image, Image Gallery, Specific view)
* Use _Transients_ with _Shortcodes_ and manage cache
* Create _User Roles_
* Manage menus visibility
* Add _Query Args_
* Manage redirections
* Add theme options on the fly with [ACF Pro](https://www.advancedcustomfields.com/pro/)
* Access to global informations, like theme settings, current Post, current user, etc.

## To-Do ##

* Fix bugs
* Refactor if necesseray
* Improve architecture
* Write good and useful tests
* Add functionalities
* Find a solution for _Widgets_
* Offer a way to decouple it from [Sage](https://github.com/roots/sage)
* Offer a way to extend it

## About the structure ##

Basically, the system works like so: a _Theme_ object, _ITheme_, acts like a _Main_. It will ask an _Initializer_ object, which implements the _IInitializer_ interface, to, obviously, initialize the whole thing. The _Initializer_ will ask a _SideFacade_, which implements the _ISideFacade_ interface, to execute the required operations and to send back settings data that will be available globally. An _ISide_ object is then created, depending on the displayed part of _WordPress_, the website itself or the _WP Admin_ part. A Side object has several _IManager_ objects that will setup a bunch of _IHandlers_ object. Each _Handler_ object is completely independent of the others and doesn’t know them. Every _Handler_ is assigned to a specific task and for that has a _IRepository_ object. Requests are performed through a _Request Service_. When a request is executed, it will ask the _Manager_ object, that it has in reference, to dispatch the request. The _Manager_ will then ask every initialized _Handler_ if it can handle the request. If it can, it will then perform the operation through its _Repository_. This last one will get the data through a _IContext_ object before putting it into an _IEntity_ object that will be encapsulated in a _IThemeObject_ object. Even if they share the same interface, every _ThemeObject_ has its own attributes and methods. Some _ThemeObject_ objects also have a _State_, implementing the _IState_ interface, that defines the behaviour they must adopt when they are called. Each _Shortcode_ object, for example, has its own specific behaviour depending of its type. A _IShortcode_ object has also access to the _TransientService_ that manages transients.

For now, because this project is based on [Sage](https://github.com/roots/sage), it uses Blade as a template engine and the _Illuminate Container_ for _Dependency Injection_.

## Usage ##

Here a few things about how to use this system.

### CPT, CT, Shortcodes, Options, etc. ###

Just set up the whole thing, hope there is no bug and go to _WP Admin_. A Settings menu should be here.

### Global Settings ###

Some settings are available through a global settings variable. It can be called like so:

    global $settings

A reference to the _Request Service_ is available through this variable.

### Request Service ###

Down below, a few examples of how to use the _Request Service_.

Querying _Posts_

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

Querying a specifc _Post_

    $this->_requestService::buildRequestAndExecute([
            'type' => 'post', 
            'action' => 'query'
            ], 
            [
            'method' => 'ByID', 
            'method_args' => [], 
            'query_args' => ['ID' => 5]
            ]);

Querying _Taxonomies_

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

## Why this project? ##

_WordPress_ is a fantastic tool. Unfortunately, it doesn't provide a real framework that allows developers to build custom things quickly. It is also necessary to repeat over and over the same lines of code when _CPT_ or _Shortcodes_ have to be added.

## Why Sage? ##

Because [Sage](https://github.com/roots/sage) is really awesome and all the people supporting this project make a fantastic work. This system is _DRY_ and allows to manage the structure of a custom _WordPress_ theme easily and elegantly.

## Why ACF Pro? ##

Because it is unnecessary to reinvent the wheel. [ACF Pro](https://www.advancedcustomfields.com/pro/) is a really powerful tool that allows to add fields to _WordPress_ very easily.

## Installation ##

Just clone this repository and place it in _wp-content/themes_. The rest is like a standard [Sage](https://github.com/roots/sage) project. The _ACF_ fields are saved in _json_ in _resources/acf-json_.