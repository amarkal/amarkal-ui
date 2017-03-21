<?php

namespace Amarkal\UI;

/**
 * Implements a Text UI component.
 */
class Component_text
extends AbstractComponent
{
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'placeholder'   => null,
            'size'          => null,
            'required'      => false,
            'readonly'      => false
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