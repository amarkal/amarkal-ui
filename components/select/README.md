# select Component

The `select` element is used to create a drop-down list.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name/id.
`data`|*array*|`null`|Yes|Specifies the list of options in the drop down menu.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.

## Example Usage

```php
amarkal_ui_render('text', array(
    'name'       => 'my-textfield',
    'data'       => array(
        'key1'   => 'Value 1',
        'key2'   => 'Value 2',
        'key3'   => 'Value 3'
     ),
    'disabled'   => false
));
```