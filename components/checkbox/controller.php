<?php

namespace Amarkal\UI;

/**
 * Implements a Checkbox UI component.
 */
class Component_checkbox
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface
{
    public $name_template = '{{name}}[]';
    
    public $composite_name_template = '{{parent_name}}[{{name}}][]';
    
    public $component_type = 'checkbox';
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => '',
            'disabled'      => false,
            'required'      => false,
            'readonly'      => false,
            'data'          => array(),
            'default'       => array(),
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