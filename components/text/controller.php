<?php

namespace Amarkal\UI;

/**
 * Implements a Text UI component.
 */
class Component_text
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface,
           FilterableComponentInterface,
           ValidatableComponentInterface
{
    public $component_type = 'text';
    
    public function default_model()
    {
        return array(
            'name'          => '',
            'id'            => '',
            'disabled'      => false,
            'placeholder'   => null,
            'size'          => null,
            'required'      => false,
            'readonly'      => false,
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