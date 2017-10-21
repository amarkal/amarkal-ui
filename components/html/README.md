# HTML Component

The `html` field allows you to display static HTML.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`html`|*string*|`''`|Yes|Specifies HTML to display.

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('html', array(
    'html' => '<p>Hello world!</p>'
));
```