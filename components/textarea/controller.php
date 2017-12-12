<?php

namespace Amarkal\UI;

/**
 * Implements a Textarea UI component.
 */
class Component_textarea
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface,
           FilterableComponentInterface,
           ValidatableComponentInterface
{
    public $component_type = 'textarea';
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => null,
            'disabled'      => false,
            'required'      => false,
            'readonly'      => false,
            'rows'          => 5,
            'default'       => '',
            'filter'        => null,
            'validation'    => null,
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