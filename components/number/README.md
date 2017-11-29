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

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`default`|*array*|`null`|No|Specifies the default value for this component.
`filter`|*function*|`null`|No|Specifies a filter function to filter the data before it is stored in the database.
`validation`|*function*|`null`|No|Specifies a validation function to validate the data before it is stored in the database. If the data is invalid, the previous value will be used (or the default value if there was no previous data), and an error message will be given.
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

The return value of a number component is a number. For example:

```json
100
```

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('number', array(
    'name'            => 'my-number-field',
    'id'              => 'my-number-field',
    'disabled'        => false,
    'readonly'        => false,
    'required'        => false,
    'size'            => 40,
    'min'             => 0,
    'max'             => 100,
    'step'            => 1
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'          => 'number',
        'name'          => 'my-number-field',
        'default'       => 0
    )
));

// The array of new values
$new_values = array(
    'my-number-field' => 1
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-number-field');
$component->render(true);
```