# Composite Component

The `composite` component is a component comprised of other components, referred to as child components. Child components can be any amarkal-ui component, including composite components.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`components`|*array*|`array()`|Yes|Specifies a list of child components.
`template`|*string*|`null`|Yes|Specifies an HTML template to be used when rendering the component. The template uses double curly braced tokens to represent child components. For example, `{{component_name}}` will be converted to a child component with the name `component_name`.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
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

The return value of a composite component is an associative array, where the keys are the component names, and the values are the component values. For example:

```json
{
    "textfield1": "value",
    "numberfield1": 3
}
```

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('composite', array(
    'name'            => 'my-composite-field',
    'id'              => 'my-composite-field',
    'disabled'        => false,
    'template'        => '<label>Text:{{my-text}}</label>',
    'components'      => array(
        array(
            'type'        => 'text',
            'name'        => 'my-text'
        )
    )
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'          => 'composite',
        'name'          => 'my-composite-field',
        'id'            => 'my-composite-field',
        'disabled'      => false,
        'template'      => '<label>Text:{{my-text}}</label>',
        'components'    => array(
            array(
                'type'        => 'text',
                'name'        => 'my-text'
            )
        ),
        'filter'        => function($v) {
            return sanitize_text_field($v['my-text']);
        },
        'validation'    => function($v,&$e) {
            if(strlen($v['my-text']) > 20) {
                $e = 'Your input must be less than 20 characters long.';
                return false;
            }
            return true;
        },
        'default'       => array(
            'my-text'     => 'Some default value'
        )
    )
));

// The array of new values
$new_values = array(
    'my-composite-field' => array(
    	'my-text' => 'Some new value'
    ) 
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-composite-field');
$component->render(true);
```