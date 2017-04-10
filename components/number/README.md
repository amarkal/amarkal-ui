# Number Component

The `number` field accepts a numeric value.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`size`|*number*|`null`|No|Specifies the width of the control in characters.
`min`|*number*|`null`|No|Specifies the minimum value.
`max`|*number*|`null`|No|Specifies the maximum value.
`step`|*number*|`null`|No|Specifies the legal number intervals for an input field.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`default`|*string*|`null`|No|Specifies the default value for this component to be used initially before any data is stored in the database. Only applicable if used in conjunction with Amarkal\UI\Form.

## Example Usage

```php
amarkal_ui_render('number', array(
    'name'            => 'my-number-field',
    'id'              => 'my-number-field',
    'disabled'        => false,
    'readonly'        => false,
    'required'        => false,
    'size'            => 40,
    'min'             => 0,
    'max'             => 100,
    'step'            => 1,
    'default'         => 0
));
```