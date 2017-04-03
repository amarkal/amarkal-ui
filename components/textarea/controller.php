<?php

namespace Amarkal\UI;

/**
 * Implements a Textarea UI component.
 */
class Component_textarea
extends AbstractComponent
{
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
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