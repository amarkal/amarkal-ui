# Code Component

The `code` creates a live code editor based on Cloud 9 Ace Editor.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`name`|*string*|`''`|Yes|Specifies the component's name.
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`language`|*string*|`null`|Yes|Specifies which programming language syntax to use. See [ace.c9.io/build/kitchen-sink.html](https://ace.c9.io/build/kitchen-sink.html) for supported languages.
`theme`|*string*|`'github'`|No|Specifies which theme to use. See [ace.c9.io/build/kitchen-sink.html](https://ace.c9.io/build/kitchen-sink.html) for available themes.
`max_lines`|*number|string*|`'Infinity'`|No|Specifies the maximum number of lines the editor should expand to before making the content scrollable. If set to 'Infinity', the editor will expand to show all lines.

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`default`|*array*|`null`|No|Specifies the default value for this component.
`filter`|*function*|`null`|No|Specifies a filter function to filter the data before it is stored in the database.
`validation`|*function*|`null`|No|Specifies a validation function to validate the data before it is stored in the database. If the data is invalid, the previous value will be used (or the default value if there was no previous data), and an error message will be given.
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Usage

No data processing (Static HTML)

## Value

This component returns a string. For example:

```json
"code line1\ncode line 2"
```

```php
$html = amarkal_ui_render('code', array(
    'name'            => 'my-code',
    'id'              => 'my-code',
    'disabled'        => false,
    'readonly'        => false,
    'required'        => false,
    'theme'           => 'github',
    'language'        => 'javascript',
    'max_lines'       => 5
));
```

Data processing using `UI\Form`

```php
$form = new Amarkal\UI\Form(array(
    array(
        'type'        => 'code',
        'name'        => 'my-code',
        'default'     => 'Some default value'
    )
));

// The array of new values
$new_values = array(
    'my-code'  => 'Some new value'
);

// Update component values
$values = $form->update($new_values);

// Render the component with the new value
$component = $form->get_component_list()->get_by_name('my-code');
$component->render(true);
```