<?php

namespace Amarkal\UI;

/**
 * Implements a select UI component.
 */
class Component_select
extends AbstractComponent
implements ValueComponentInterface
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
    
    public function required_arguments()
    {
        return array('name','data');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
}