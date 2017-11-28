<?php

namespace Amarkal\UI;

/**
 * Implements a Radio UI component.
 */
class Component_radio
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface
{
    public $component_type = 'radio';
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => '',
            'disabled'      => false,
            'required'      => false,
            'readonly'      => false,
            'data'          => array(),
            'default'       => null,
            'show'          => null
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