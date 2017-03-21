<?php

namespace Amarkal\UI;

/**
 * Implements a Text UI component.
 * 
 * Parameters:
 * <ul>
 * <li><b>name</b> <i>string</i> The component's name.</li>
 * <li><b>disabled</b> <i>boolean</i> True to disabled component. False otherwise.</li>
 * <li><b>placeholder</b> <i>string</i> Text to be used when the input is empty.</li>
 * </ul>
 * 
 * Usage Example:
<pre>
amarkal_ui_render('text', array(
    'name'            => 'textfield_1',
    'default'         => 'Enter your title here',
    'placeholder'     => 'Enter text...',
    'disabled'        => false,
    'filter'          => function( $v ) { return trim( strip_tags( $v ) ); },
    'validation'      => function( $v, &$e ) {
        $valid = strlen($v) <= 25;
        $e = 'Text must be less than 25 characters long'
        return $valid;
    }
));
</pre>
 */
class Component_text
extends AbstractComponent
{
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'placeholder'   => ''
        );
    }
    
    public function required_parameters()
    {
        return array('name');
    }
    
    public function get_script_path() 
    {
        return __DIR__.'/template.phtml';
    }
}