# Text Component

The `text` field accepts any form of text.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`placeholder`|*string*|`null`|No|Text to display in the input when no value is present.
`size`|*number*|`null`|No|Specifies the width of the control in characters.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.

## Example Usage

```php
amarkal_ui_render('text', array(
    'name'            => 'my-textfield',
    'placeholder'     => 'Enter text...',
    'disabled'        => false
));
```