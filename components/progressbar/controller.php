<?php

namespace Amarkal\UI;

/**
 * Implements a Progress Bar UI component.
 */
class Component_progressbar
extends AbstractComponent
{
    public $component_type = 'progressbar';
    
    public function default_model() 
    {
        return array(
            'min'           => null,
            'max'           => null,
            'value'         => null,
            'show'          => null
        );
    }
    
    public function required_arguments()
    {
        return array('value','min','max');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
}