# Toggle Component

The `toggle` field accepts lets the user select one or more options from a list of options.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form.
`multi`|*boolean*|`false`|No|Specifies whether the field should accept more than one user selection.
`data`|*array*|`null`|Yes|Specifies the list of button labels as `'value' => 'Label'`.

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`default`|*array|string*|`array()`|No|Specifies the default value for this component. If `multi` is set to `true`, this should be an array. Otherwise it should be a string.
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

This component returns a string (if `multi` is set to `false`) or an array (if `multi` is set to `true`). For example:

```json
["value1","value2"]
// Or
"value1"
```

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('toggle', array(
    'name'            => 'my-toggle',
    'id'              => 'my-toggle',
    'disabled'        => false,
    'readonly'        => false,
    'required'        => false,
    'multi'           => false,
    'data'            => array(
        'key1'  => 'Value 1',
        'key2'  => 'Value 2',
        'key3'  => 'Value 3'
    )
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'        => 'toggle',
        'name'        => 'my-toggle',
        'default'     => 'key1',
        'data'        => array(
            'key1'  => 'Value 1',
            'key2'  => 'Value 2',
            'key3'  => 'Value 3'
        )
    )
));

// The array of new values
$new_values = array(
    'my-toggle'  => 'key2'
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-toggle');
$component->render(true);
```