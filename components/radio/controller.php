<?php

namespace Amarkal\UI;

/**
 * Implements a Radio UI component.
 */
class Component_radio
extends AbstractComponent
implements ValueComponentInterface
{
    public function default_model() 
    {
        return array(
            'name'          => '',
            'disabled'      => false,
            'required'      => false,
            'readonly'      => false,
            'data'          => array()
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