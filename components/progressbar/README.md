# Progressbar Component

The `progressbar` field is a static field that does not take user input, and is used to display profress in a visual way.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`min`|*number*|`null`|Yes|Specifies the minimum value.
`max`|*number*|`null`|Yes|Specifies the maximum value.
`value`|*number*|`null`|Yes|Specifies the value to be shown in the progress bar

## Usage

No data processing (Static HTML)

```php
$html = amarkal_ui_render('progressbar', array(
    'min'             => 0,
    'max'             => 100,
    'value'           => 50
));
```