<?php

namespace Amarkal\UI;

/**
 * Implements an HTML UI component.
 */
class Component_html
extends AbstractComponent
{
    public $component_type = 'html';
    
    public function default_model() 
    {
        return array(
            'html'          => '',
            'template'      => false,
            'show'          => null
        );
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
}