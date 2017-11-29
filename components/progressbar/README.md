# Progressbar Component

The `progressbar` field is a static field that does not take user input, and is used to display profress in a visual way.

## Arguments

Name | Type | Default | Required | Description
---|---|---|:---:|---
`min`|*number*|`null`|Yes|Specifies the minimum value.
`max`|*number*|`null`|Yes|Specifies the maximum value.
`value`|*number*|`null`|Yes|Specifies the value to be shown in the progress bar

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
$html = amarkal_ui_render('progressbar', array(
    'min'             => 0,
    'max'             => 100,
    'value'           => 50
));
```