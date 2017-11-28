<?php

namespace Amarkal\UI;

/**
 * Implements a number UI component.
 */
class Component_number
extends AbstractComponent
implements ValueComponentInterface, 
           DisableableComponentInterface,
           FilterableComponentInterface,
           ValidatableComponentInterface
{
    public $component_type = 'number';
    
    public function default_model() 
    {
        return array(
            'name'          => '',
            'id'            => '',
            'disabled'      => false,
            'size'          => null,
            'min'           => null,
            'max'           => null,
            'step'          => null,
            'required'      => false,
            'readonly'      => false,
            'default'       => null,
            'filter'        => array( $this, 'filter' ),
            'validation'    => array( $this, 'validation' ),
            'show'          => null
        );
    }
    
    public function filter($v)
    {
        return floatval($v);
    }
    
    public function validation($v,&$e)
    {
        $max = $this->max;
        $min = $this->min;
        
        if(null !== $max && $v > $max)
        {
            $e = sprintf( __("Value must be less than %d",'amarkal'), $max);
        }

        if(null !== $min && $v < $min) 
        {
            $e = sprintf( __("Value must be greater than %d",'amarkal'), $min);
        }

        return $e ? false : true;
    }
    
    public function required_arguments()
    {
        return array('name');
    }
    
    public function get_template_path() 
    {
        return __DIR__.'/template.phtml';
    }
}