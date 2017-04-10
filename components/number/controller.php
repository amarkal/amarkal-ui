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
            'validation'    => array( $this, 'validation' )
        );
    }
    
    public function filter($v)
    {
        return floatval($v);
    }
    
    public function validation($v,&$e)
    {
        if($v > $this->max) 
        {
            $e = "must be less than {$this->max}";
        }

        if($v < $this->min) 
        {
            $e = "must be greater than {$this->min}";
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