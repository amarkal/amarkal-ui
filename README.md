# amarkal-ui [![Build Status](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/badges/build.png?b=master)](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/askupasoftware/amarkal-ui/?branch=master) [![Built with Grunt](https://cdn.gruntjs.com/builtwith.svg)](https://gruntjs.com/) [![Amarkal Powered](https://askupasoftware.com/amarkal-powered.svg)](https://products.askupasoftware.com/amarkal) [![License](https://img.shields.io/badge/license-GPL--3.0%2B-red.svg)](https://raw.githubusercontent.com/askupasoftware/amarkal-ui/master/LICENSE)
A set of UI components for WordPress.

**Tested up to:** WordPress 4.7  
**Dependencies:** *[amarkal-core](https://github.com/askupasoftware/amarkal-core)*

## overview

**amarkal-ui** is a set of UI components that can be used for building anything from user contact forms to admin options pages.

### Available Components

* [Text](https://github.com/askupasoftware/amarkal-ui/tree/master/components/text)
* [Textarea](https://github.com/askupasoftware/amarkal-ui/tree/master/components/textarea)
* [Number](https://github.com/askupasoftware/amarkal-ui/tree/master/components/number)
* [Select](https://github.com/askupasoftware/amarkal-ui/tree/master/components/select)
* [Radio](https://github.com/askupasoftware/amarkal-ui/tree/master/components/radio)
* [Checkbox](https://github.com/askupasoftware/amarkal-ui/tree/master/components/checkbox)
* [Composite](https://github.com/askupasoftware/amarkal-ui/tree/master/components/composite)
* [Switch](https://github.com/askupasoftware/amarkal-ui/tree/master/components/switch)
* [Slider](https://github.com/askupasoftware/amarkal-ui/tree/master/components/slider)
* [Button](https://github.com/askupasoftware/amarkal-ui/tree/master/components/button)
* [Toggle](https://github.com/askupasoftware/amarkal-ui/tree/master/components/toggle)
* [Code](https://github.com/askupasoftware/amarkal-ui/tree/master/components/code)
* [Progress Bar](https://github.com/askupasoftware/amarkal-ui/tree/master/components/progressbar)
* Color Picker (coming soon)
* Attachment (coming soon)
* Editor (coming soon)
* Date (coming soon)
* Progress Bar (coming soon)
* HTML (coming soon)

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

## Processing Form Data

You can process form data by using `Amarkal\UI\Form`. The `Form` object takes a list of UI components and loops through them to produce the final values that can then be stored into the database or further processed.

### Instantiating The Form Object

When instantiating a Form object, an array of UI components must be provided as an argument. These UI components can have default values, and some components can have filter and validation functions.

```php
$form = new Amarkal\UI\Form(array(
    array(
        'name'    => 'my-textfield',
        'type'    => 'text',
        'default' => 'Some text'
    ),
    array(
        'name'    => 'my-textarea',
        'type'    => 'textarea',
        'default' => 'Some text'
    )
));
```

### Updating Form Values

The `Form::update()` function can be use to process form submissions and produce a filtered & validated set of values that can be safely stored in the database. The `Form::update()` function takes an array of old and new values (referred to as `$old_instance` and `$new_instance`) and uses them to produce a list of final values (referred to as `$new_instance`). When calling the `Form::update()` function, the form object will loop through all the form's UI components, and will do the following in each iteration:

* If the component is disabled, the default value will be used and no processing will occur.
* If the `$new_instance` does not have a value for the given component, the value in `$old_instance` will be used.
* If the `$new_instance` and `$old_instance` both do not have a value for the given component, the default value will be used.
* If the `$new_instance` has a value for the given component, that value will be filtered and validated (if applicabale) before being placed in the `$final_instance`.

```php
// Example for processing a POST form submission
$new_instance = filter_input_array(INPUT_POST);
$old_instance = array(); // This can be the values previously stored in the database
$final_instance = $form->update($new_instance, $old_instance);
```

### Displaying Errors

During the processing of component values, if a validatable component is found to be invalid (via its validation function), an error message will be stored in the Form's `$errors` array as `'component_name' => 'error_message'`. The list of errors can be retrieved using `Form::get_errors()`. For example:

```php
// Instantiate a form object
$form = new Amarkal\UI\Form(array(
    array(
        'name'       => 'my-numberfield',
        'type'       => 'number',
        'default'    => 0,
        'validation' => function($v,&$e) {
            if($v > 10) {
               $e = 'must be less than or equal to 10';
               return false;
            }
            return true;
        }
    )
));

// Update form with invalid values
$new_instance = array(
    'my-numberfield' => 20
);
$final_instance = $form->update($new_instance);
$errors = $form->get_errors();

var_dump($errors);
```

The above will print:

```
array(1) {
    ["my-numberfield"]=>
    string(32) "must be less than or equal to 10"
}
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
