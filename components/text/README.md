# Text Component

The `text` field accepts any form of text.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`placeholder`|*string*|`null`|No|Text to display in the input when no value is present.
`size`|*number*|`null`|No|Specifies the width of the control in characters.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form.

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`default`|*array*|`''`|No|Specifies the default value for this component.
`filter`|*function*|`null`|No|Specifies a filter function to filter the data before it is stored in the database.
`validation`|*function*|`null`|No|Specifies a validation function to validate the data before it is stored in the database. If the data is invalid, the previous value will be used (or the default value if there was no previous data), and an error message will be given.
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

This component returns a string. For example:

```json
"My text value..."
```

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('text', array(
    'name'            => 'my-textfield',
    'id'              => 'my-textfield',
    'disabled'        => false,
    'readonly'        => false,
    'placeholder'     => 'Enter text...',
    'size'            => 40,
    'required'        => false
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'        => 'textfield',
        'name'        => 'my-textfield',
        'default'     => 'Some default value',
        'filter'          => function($v) {
            return sanitize_text_field($v);
        },
        'validation'      => function($v,&$e) {
            if(strlen($v) > 20) {
                $e = 'Your input must be less than 20 characters long.';
                return false;
            }
            return true;
        }
    )
));

// The array of new values
$new_values = array(
    'my-textfield'  => 'Some new value'
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-textfield');
$component->render(true);
```
