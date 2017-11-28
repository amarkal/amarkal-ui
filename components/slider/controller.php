<?php

namespace Amarkal\UI;

/**
 * Implements a Slider UI component.
 */
class Component_slider
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface,
           FilterableComponentInterface
{
    public $component_type = 'slider';
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => '',
            'disabled'      => false,
            'required'      => false,
            'readonly'      => false,
            'default'       => null,
            'min'           => null,
            'max'           => null,
            'step'          => 1,
            'filter'        => array( $this, 'filter' ),
            'show'          => null
        );
    }
    
    public function required_arguments()
    {
        return array('name','min','max');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }

    /**
     * This filter is needed when the form is submitted without $.amarkalUIForm.
     * When using $.amarkalUIForm to submit the form, the component's getValue/setValue 
     * will handle this.
     *
     * @param [string] $v
     * @return void
     */
    public function filter($v)
    {
        return \floatval($v);
    }
}