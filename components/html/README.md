# HTML Component

The `html` field allows you to display static HTML.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`html`|*string*|`''`|Yes|Specifies HTML to display.
`template`|*string*|`''`|Yes|Specifies a path to a template `.phtml` file

### Additional `UI\Form` Arguments

When using `Amarkal\UI\Form` to process component data, the following arguments may be used in addition to the basic component arguments.

Name | Type | Default | Required | Description
---|---|---|:---:|---
`show`|*string*|`null`|No|Specifies visibility condition for this component. See [visibility conditions](../../../../#visibility-conditions)

## Value

This component has no value.

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('html', array(
    'html' => '<p>Hello world!</p>'
));
```