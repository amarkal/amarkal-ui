# Radio Component

The `radio` field lets the user select one and only one option from a set of alternatives.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`data`|*array*|`null`|Yes|Specifies the list of radio buttons as `'value' => 'Label'`.

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`default`|*array*|`null`|No|Specifies the default value for this component.
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

This component returns a string corresponding to the selected value. For example:

```json
"value1"
```

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('radio', array(
    'name'     => 'my-radio',
    'disabled' => false,
    'data'     => array(
        'key1'   => 'Value 1',
        'key2'   => 'Value 2',
        'key3'   => 'Value 3'
    )
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'     => 'radio',
        'name'     => 'my-radio',
        'data'     => array(
            'key1'   => 'Value 1',
            'key2'   => 'Value 2',
            'key3'   => 'Value 3'
        ),
        'default'  => 'key1'
    )
));

// The array of new values
$new_values = array(
    'my-radio'  => 'key2'
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-radio');
$component->render(true);
```