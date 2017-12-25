# amarkal-ui [![Build Status](https://scrutinizer-ci.com/g/amarkal/amarkal-ui/badges/build.png?b=master)](https://scrutinizer-ci.com/g/amarkal/amarkal-ui/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/amarkal/amarkal-ui/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/amarkal/amarkal-ui/?branch=master) [![Built with Grunt](https://cdn.gruntjs.com/builtwith.svg)](https://gruntjs.com/) [![Amarkal Powered](https://askupasoftware.com/amarkal-powered.svg)](https://products.askupasoftware.com/amarkal) [![License](https://img.shields.io/badge/license-GPL--3.0%2B-red.svg)](https://raw.githubusercontent.com/amarkal/amarkal-ui/master/LICENSE)
A set of UI components for WordPress.

**Tested up to:** WordPress 4.7  
**Dependencies:** *[amarkal-core](https://github.com/amarkal/amarkal-core)*

## overview

**amarkal-ui** is a set of UI components and tools that can be used for building user interfaces in a WordPress environment.

### Available Components

* [Text](https://github.com/amarkal/amarkal-ui/tree/master/components/text)
* [Textarea](https://github.com/amarkal/amarkal-ui/tree/master/components/textarea)
* [Number](https://github.com/amarkal/amarkal-ui/tree/master/components/number)
* [Select](https://github.com/amarkal/amarkal-ui/tree/master/components/select)
* [Radio](https://github.com/amarkal/amarkal-ui/tree/master/components/radio)
* [Checkbox](https://github.com/amarkal/amarkal-ui/tree/master/components/checkbox)
* [Composite](https://github.com/amarkal/amarkal-ui/tree/master/components/composite)
* [Switch](https://github.com/amarkal/amarkal-ui/tree/master/components/switch)
* [Slider](https://github.com/amarkal/amarkal-ui/tree/master/components/slider)
* [Button](https://github.com/amarkal/amarkal-ui/tree/master/components/button)
* [Toggle](https://github.com/amarkal/amarkal-ui/tree/master/components/toggle)
* [Code](https://github.com/amarkal/amarkal-ui/tree/master/components/code)
* [Progress Bar](https://github.com/amarkal/amarkal-ui/tree/master/components/progressbar)
* [HTML](https://github.com/amarkal/amarkal-ui/tree/master/components/html)
* Color Picker (coming soon)
* Attachment (coming soon)
* Editor (coming soon)
* Date (coming soon)

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

[Download the package](https://github.com/amarkal/amarkal-ui/archive/master.zip) from github and include `bootstrap.php` in your project.

```php
require_once 'path/to/amarkal-ui/bootstrap.php';
```

## Rendering components

The `amarkal_ui_render($type, $props)` method is used to generate the HTML of the component whose `$type` is given. For example, the following code will 
render a `text` component:

```php
echo amarkal_ui_render('text', array(
    'name'        => 'my-textfield',
    'value'       => 'Some cool value...'
));
```

And the output will be:

```html
<div class="amarkal-ui-component amarkal-ui-component-text" amarkal-component-name="my-textfield">
    <script class="amarkal-ui-component-props" type="application/json">{"name":"my-textfield","id":"my-textfield","value":"Some cool value..."}</script>
    <input type="text" id="my-textfield" name="my-textfield" value="Some cool value...">
</div>
```

You can then use `jQuery(...).amarkalUIComponent()` to control the component in the front-end. For example, to get its value, you can call:

```js
var value = $('.amarkal-ui-component-text').amarkalUIComponent('getValue');
```

## Working with forms

While you can use components individually, when you have multiple components it makes sense to work in the context of a form. The `Amarkal\UI\Form` PHP class and its corresponding jQuery method `jQuery.amarkalUIForm(...)` allows you to easily process data and communicate it between the server and the client. Additionally, working with forms allows you to specifiy visibility conditions to any form components.

### Data processing

The `Amarkal\UI\Form` object takes a list of UI components and loops through them to produce the final values that can then be stored into the database or further processed.

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

### Visibility conditions

When working in the context of forms, components can receive visibility conditions to show/hide them based on the values of other components in the form. For example:

```php
$form = new Amarkal\UI\Form(array(
    array(
        'name'       => 'my_number',
        'type'       => 'number'
    ),
    array(
        'name'       => 'my_text',
        'type'       => 'text',
        'show'       => '{{my_number}} === 3'
    )
));
```

Based on the above condition, `my_text` will only be visible if the value of `my_number` equals 3.

**Syntax**

Visibility conditions are written in pure javascript, while component values can be insrted to them by using double curly braces around the component's name (i.e. `{{component_name}}`). The component placeholders are replaced during runtime by the component's value. This means that you can write simple conditions like:
```
{{my_text}} === 'foo'
```
Or more complex conditions, like:
```
{{my_switch}} === 'on' && {{my_slider}} >= 30
```
Or even use functions:
```
Math.floor({{my_number}}) >= 10
```

**How does it work?**

Internally, Amarkal uses a graph data structure to describe the relationships between all the components, based on their visibility conditions. When a component changes its value, the algorithm checks if there are other compnents that might be affected by this change, and evaluates their condition to see if their visibility state should be changed.

> NOTE: Components with a visibility condition MUST have a name

## Reference

### PHP Reference

#### amarkal_ui_render
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
echo amarkal_ui_render('text', array(
    'name'        => 'my-textfield',
    'value'       => 'Some cool value...'
));
```

#### amarkal_ui_register_component
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

### JS Reference

#### jQuery.amarkalUIComponent(...)

Instantiate an amarkal UI component and/or call a component's method.

**Supported methods**
* `getValue()`

  Returns the value of the component
  ```js
  var value = $('#my-component').amarkalUIComponent('getValue');
  ```
* `setValue( value )`

  Sets the value of the component
  ```js
  var value = 'foo';
  $('#my-component').amarkalUIComponent('setValue', value);
  ```
* `getProps()`

  Get the `props` object for this component.
  ```js
  var props = $('#my-component').amarkalUIComponent('getProps');
  ```
* `setProps()`

  Merge the `props` object of this component with the given object.
  ```js
  $('#my-component').amarkalUIComponent('setProps', {propName: 'propValue'});
  ```
* `getName()`

  Get the name of this component. Similar to calling `getProps().name`, with the only difference that this method will return `false` if the component does not have a name.
  ```js
  var name = $('#my-component').amarkalUIComponent('getName');
  ```
* `reset()`

  Reset this component to its default state.
  ```js
  $('#my-component').amarkalUIComponent('reset');
  ```
* `refresh()`

  Re-render this component. This is applicable for components whose appearance depends on their container element, like the `slider` component. For such components, it is necessary to refresh them after their container's width has changed, or when it turns from a hidden to a visible state.
  ```js
  $('#my-component').amarkalUIComponent('reset');
  ```
* `changed()`

  Check if the component has changed its value by comparing its initial value with its current value.
  ```js
  var changed = $('#my-component').amarkalUIComponent('changed');
  ```
* `instance()`

  Returns the instance object for this component.
  ```js
  var instance = $('#my-component').amarkalUIComponent('instance');
  instance.setValue('foo');
  ```

#### Events
* `amarkal.change`

  Triggered when the component's value changes.
  ```js
  $('#my-component').on('amarkal.change', function(){...});
  ```
* `amarkal.show`

  Triggered when the component's visibility condition turns from unsatisfied to satisfied.
  ```js
  $('#my-component').on('amarkal.show', function(){...});
  ```
* `amarkal.hide`

  Triggered when the component's visibility condition turns from satisfied to unsatisfied.
  ```js
  $('#my-component').on('amarkal.hide', function(){...});
  ```

  #### jQuery.amarkalUIForm(...)

  Instantiate an amarkal UI form, and/or call a form's method.

  **Supported methods**
* `getData()`

  Returns an object containing the values of all the components in the form.
  ```js
  var values = $('#my-form').amarkalUIForm('getData');
  // 'values' is an object whose keys are the names of all the components names
  ```
* `setData( data )`

  Sets the values of all the components based on the given data object.
  ```js
  var data = {
      'component_name': 'component_value'
  };
  $('#my-form').amarkalUIForm('setData', data);
  ```
* `getValue( name )`

  Get the value of the component whose name is given.
  ```js
  var value = $('#my-form').amarkalUIForm('getValue', 'component_name');
  ```
* `getComponent( name )`

  Get the instance of the component whose name is given.
  ```js
  var $component = $('#my-form').amarkalUIForm('getComponent', 'component_name');
  ```
* `isVisible( name )`

  Get the visibility state of the component whose name is given, based on its visibility condition.
  ```js
  var visible = $('#my-form').amarkalUIForm('isVisible', 'component_name');
  ```
* `refresh()`

  Refresh all the components in this form.
  ```js
  $('#my-form').amarkalUIForm('refresh');
  ```
* `changed()`

  Check if any of the values in the form has changed by comparing its current value with its initial value.
  ```js
  var changed = $('#my-form').amarkalUIForm('changed');
  ```