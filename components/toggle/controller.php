<?php

namespace Amarkal\UI;

/**
 * Implements a Toggle UI component.
 */
class Component_toggle
extends AbstractComponent
implements ValueComponentInterface,
           FilterableComponentInterface,
           DisableableComponentInterface
{
    public $component_type = 'toggle';
    
    protected function on_created() 
    {
        if($this->multi && !\is_array($this->default)
        || !$this->multi && \is_array($this->default))
        {
            throw new \RuntimeException("The default value must be an array if multi is set to true, and must be a string otherwise.");
        }
    }

    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => '',
            'disabled'      => false,
            'required'      => false,
            'readonly'      => false,
            'multi'         => false,
            'data'          => array(),
            'default'       => array(),
            'filter'        => array( $this, 'filter' ),
            'show'          => null
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

    /**
     * This filter is needed when the form is submitted without $.amarkalUIForm, 
     * since the value of the toggle needs to be splitted into an array (when 'multi' is set to true). 
     * When using $.amarkalUIForm to submit the form, the component's getValue/setValue will
     * handle this.
     *
     * @param [string|array] $v
     * @return [string|array]
     */
    public function filter($v)
    {
        if($this->multi && !\is_array($v)) 
        {
            return \explode(',', $v);
        }
        return $v;
    }

    protected function is_selected( $value )
    {
        if($this->multi) 
        {
            return \in_array($value, $this->value);
        }
        return $value === $this->value;
    }
}