<?php

namespace Amarkal\UI;

/**
 * Implements a number UI component.
 */
class Component_number
extends AbstractComponent
{
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'size'          => null,
            'min'           => null,
            'max'           => null,
            'step'          => null,
            'required'      => false,
            'readonly'      => false
        );
    }
    
    public function required_arguments()
    {
        return array('name');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
}