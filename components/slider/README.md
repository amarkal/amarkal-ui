# Slider Component

The `slider` field lets the user a numberic value from a range of values.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`required`|*boolean*|`false`|No|Specifies that an input field must be filled out before submitting the form.
`min`|*number*|`null`|No|Specifies the minimum value.
`max`|*number*|`null`|No|Specifies the maximum value.
`step`|*number*|`null`|No|Specifies the legal number intervals for an input field.

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`default`|*array*|`null`|No|Specifies the default value for this component.
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

This component returns a number. For example:

```json
15.7
```

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('slider', array(
    'name'            => 'my-slider',
    'id'              => 'my-slider',
    'disabled'        => false,
    'readonly'        => false,
    'required'        => false,
    'min'             => 0,
    'max'             => 100
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'        => 'slider',
        'name'        => 'my-slider',
        'default'     => 50
    )
));

// The array of new values
$new_values = array(
    'my-slider'  => 100
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-slider');
$component->render(true);
```