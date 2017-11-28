<?php

namespace Amarkal\UI;

/**
 * Implements a Code UI component.
 */
class Component_code
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface,
           FilterableComponentInterface,
           ValidatableComponentInterface
{
    public $component_type = 'code';
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => null,
            'disabled'      => false,
            'readonly'      => false,
            'default'       => null,
            'language'      => null,
            'theme'         => 'github',
            'max_lines'     => 'Infinity', // Or a positive integer
            'filter'        => null,
            'validation'    => null,
            'show'          => null
        );
    }
    
    public function required_arguments()
    {
        return array('name','language');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }

    public function enqueue_scripts()
    {
        parent::enqueue_scripts();
        \wp_enqueue_script('ace-editor');
    }
}