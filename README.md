# amarkal-ui [![Build Status](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/badges/build.png?b=master)](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/?branch=master) [![License](https://img.shields.io/badge/license-GPL--3.0%2B-red.svg)](https://raw.githubusercontent.com/askupasoftware/amarkal-ui/master/LICENSE)
A set of HTML UI components for WordPress.

**Tested up to:** WordPress 4.7  
**Dependencies:** none

## overview

**amarkal-ui** is a set of HTML UI components that can be used for building anything from user contact forms to admin options pages.

### Available Components

* [text](https://github.com/askupasoftware/amarkal-ui/tree/master/components/text)
* [textarea](https://github.com/askupasoftware/amarkal-ui/tree/master/components/textarea)
* [number](https://github.com/askupasoftware/amarkal-ui/tree/master/components/number)
* [select](https://github.com/askupasoftware/amarkal-ui/tree/master/components/select)
* [radio](https://github.com/askupasoftware/amarkal-ui/tree/master/components/radio)
* [checkbox](https://github.com/askupasoftware/amarkal-ui/tree/master/components/checkbox)

## Installation

### Via Composer

If you are using the command line:  
```
$ composer require askupa-software/amarkal-ui:dev-master
```

Or simply add the following to your `composer.json` file:
```javascript
"require": {
     "askupa-software/amarkal-ui": "dev-master"
 }
```
And run the command 
```
$ composer install
```

This will install the package in the directory `vendors/askupa-software/amarkal-ui`.  
Now all you need to do is include the composer autoloader.

```php
require_once 'path/to/vendor/autoload.php';
```

### Manually

[Download the package](https://github.com/askupasoftware/amarkal-ui/archive/master.zip) from github and include `bootstrap.php` in your project.

```php
require_once 'path/to/amarkal-ui/bootstrap.php';
```

## Reference

### amarkal_ui_render
*Render a UI component.*
```php
amarkal_ui_render( $type, array $props = array() )
```
This function is used to render the HTML of a UI component of type `$type` with the properties given in `$props`. To see the list of available components, go to `amarkal-ui\components\`. The `$type` is a string corresponding to the name of the folder in which the component is stored in. The rendered HTML is returned as a string.

**Parameters**  
* `$type` (*String*)  The component's type - one of the core component types, or a registered custom component.
* `$props` (*Array*)  The component's properties.

**Example Usage**
```php
amarkal_ui_render('text', array(
    'name'        => 'my-textfield',
    'value'       => 'Some cool value...'
));
```

### amarkal_ui_register_component
*Register a custom UI component.*
```php
amarkal_ui_register_component( $type, $class_name )
```
This function can be used to register a custom UI component, or to override an existing UI component. The registered component's class should inherit from `Amarkal\UI\AbstractComponent`. See one of the core components `controller.php` file as an exapmle of implementation of a component class.

**Parameters**  
* `$type` (*String*)  The component's type. If `$type` is similar to one of the core component's type, it will override the core component.
* `$class_name` (*String*)  The component's class name.

**Example Usage**
```php
class MyCustomComponent extends Amarkal\UI\AbstractComponent
{
    public function get_script_path() 
    {
        return 'path/to/template.phtml';
    }
}
amarkal_ui_register_component('my_custom_component', 'MyCustomComponent');

// Then render it using amarkal_ui_render
echo amarkal_ui_render('my_custom_component', array(
    'prop' => 'value'
));
```
