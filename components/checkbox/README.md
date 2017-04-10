# Checkbox Component

The `checkbox` field lets the user select one or more options from a set of alternatives.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`data`|*array*|`null`|Yes|Specifies the list of checkboxes as `'value' => 'Label'`.
`default`|*array*|`null`|No|Specifies the default value for this component to be used initially before any data is stored in the database. Only applicable if used in conjunction with Amarkal\UI\Form.

## Example Usage

```php
amarkal_ui_render('checkbox', array(
    'name'     => 'my-checkboxes',
    'disabled' => false,
    'data'     => array(
        'key1'   => 'Value 1',
        'key2'   => 'Value 2',
        'key3'   => 'Value 3'
    ),
    'default'  => array('key1','key2')
));
```