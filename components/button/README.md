# Button Component

The `button` is used to execute an HTTP request to the server asynchronously.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`id`|*string*|`''`|No|Specifies the component's id. Same as the component's name if none was specified.
`disabled`|*boolean*|`false`|No|Disables the input control. The button won't accept changes from the user. It also cannot receive focus and will be skipped when tabbing.
`readonly`|*boolean*|`false`|No|Sets the input control to read-only. It won't allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.
`label_start`|*string*|`null`|Yes|Specifies the button's label that is shown initially.
`label_doing`|*string*|`'Processing...'`|No|Specifies the button's label when the request is being made.
`label_done`|*string*|`'Done'`|No|Specifies the button's label when the request is completed successfully.
`label_error`|*string*|`'Error'`|No|Specifies the button's label when the server returns an error.
`request_url`|*string*|`null`|Yes|Specifies the URL for the request.
`request_data`|*array*|`array()`|No|Specifies the set of parameters to be sent to the server. You can use double curley braces to insert component values from the containing form (see example below).
`request_method`|*string*|`'POST'`|No|Specifies the HTTP method for the request (`'POST'`, `'GET'` etc.).

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

This component has no value.

## Usage

```php
$html = amarkal_ui_render('button', array(
    'id'              => 'my-button',
    'disabled'        => false,
    'readonly'        => false,
    'request_url'     => admin_url('admin-ajax.php'),
    'request_data'    => array(
        'action'        => 'my_button_callback'
    )
    'label_start'     => 'Do Something'
));

// Register a callback using the wp_ajax action
add_action('wp_ajax_my_button_callback', 'button_callback');
function button_callback() {
    echo 'Hello World!';
    wp_die();
}
```

### Sending component values with `UI\Form`

You can retrieve the values of other components in the containing form and send them as request data by using double curley braces around their names, i.e. `{{component_name}}`.

```php
$form = new Amarkal\UI\Form(array(
    array(
        'name'          => 'my_text',
        'type'          => 'text'
    ),
    array(
        'type'          => 'button',
        'request_url'   => admin_url('admin-ajax.php'),
        'request_data'  => array(
            'action'        => 'my_button_callback',
            'text'          => '{{my_text}}'
        )
        'label_start'   => 'Do Something'
    )
));
```