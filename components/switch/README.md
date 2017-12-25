# Switch Component

The `switch` field lets the user select between two options - ON or OFF.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`default`|*array*|`'off'`|No|Specifies the default value for this component.
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

This component returns a string of either `"on"` or `"off"`.

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('switch', array(
    'name'            => 'my-switch',
    'id'              => 'my-switch',
    'disabled'        => false,
    'readonly'        => false,
    'required'        => false
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'        => 'switch',
        'name'        => 'my-switch',
        'default'     => 'on'
    )
));

// The array of new values
$new_values = array(
    'my-switch'  => 'Some new value'
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-switch');
$component->render(true);
```