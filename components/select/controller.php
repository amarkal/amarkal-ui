<?php

namespace Amarkal\UI;

/**
 * Implements a select UI component.
 */
class Component_select
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface
{
    public $component_type = 'select';
    
    public function default_model() 
    {   
        return array(
            'name'      => '',
            'id'        => '',
            'disabled'  => false,
            'data'      => array(),
            'required'  => false,
            'readonly'  => false,
            'default'   => null,
            'show'      => null
        );
    }
    
    public function required_arguments()
    {
        return array('name','data');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
}