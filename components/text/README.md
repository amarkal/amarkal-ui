# Text Component

The `text` field accepts any form of text and can be optionally checked against a regex.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|The component's name/id.
`disabled`|*boolean*|`false`|Yes|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`placeholder`|*string*|`null`|Yes|Text to display in the input when no value is present.
`size`|*number*|`null`|Yes|Specifies the width of the control in characters.
`required`|*boolean*|`false`|Yes|Specifies that an input field must be filled out before submitting the form
`readonly`|*boolean*|`false`|Yes|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.

## Example Usage

```php
amarkal_ui_render('text', array(
    'name'            => 'my-textfield',
    'placeholder'     => 'Enter text...',
    'disabled'        => false
));
```