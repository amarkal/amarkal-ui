<?php

namespace Amarkal\UI;

/**
 * Implements a Button UI component.
 */
class Component_button
extends AbstractComponent
implements DisableableComponentInterface
{
    public $component_type = 'button';
    
    public function default_model() 
    {
        return array(
            'id'             => '',
            'disabled'       => false,
            'readonly'       => false,
            'label_start'    => null,
            'label_doing'    => 'Processing...',
            'label_done'     => 'Done',
            'label_error'    => 'Error',
            'request_url'    => null,
            'request_data'   => array(),
            'request_method' => 'POST',
            'show'           => null
        );
    }
    
    public function required_arguments()
    {
        return array('request_url','label_start');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
}