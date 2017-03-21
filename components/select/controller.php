<?php

namespace Amarkal\UI;

/**
 * Implements a select UI component.
 */
class Component_select
extends AbstractComponent
{
    public function default_model() 
    {
        return array(
            'name'      => '',
            'disabled'  => false,
            'data'      => array(),
            'required'  => false,
            'readonly'  => false
        );
    }
    
    public function required_parameters()
    {
        return array('name','data');
    }
    
    public function get_script_path() 
    {
        return __DIR__.'/template.phtml';
    }
}