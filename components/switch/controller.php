<?php

namespace Amarkal\UI;

/**
 * Implements a Switch UI component.
 */
class Component_switch
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface,
           FilterableComponentInterface
{
    public $component_type = 'switch';
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => '',
            'disabled'      => false,
            'readonly'      => false,
            'default'       => 'off',
            'filter'        => array( $this, 'filter' ),
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

    /**
     * This filter is needed when the form is submitted without $.amarkalUIForm, 
     * since the value of the checkbox becomes NULL when it is unchecked. When using 
     * $.amarkalUIForm to submit the form, the component's getValue/setValue will
     * handle this.
     *
     * @param [string] $v
     * @return void
     */
    public function filter($v)
    {
        if($v !== 'on') return 'off';
        return 'on';
    }
}