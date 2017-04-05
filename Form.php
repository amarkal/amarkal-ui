<?php

namespace Amarkal\UI;

/**
 * Implements a Form controller.
 * 
 * The form object is used to encapsulate UI components and the update/validation 
 * process into a single entity.
 */
class Form
{
    /**
     * The list of AbstractComponent type objects to be updated.
     * 
     * @var AbstractComponent[] objects array.
     */
    private $components;
    
    /**
     * The old component values array. These values are used if the new values
     * are invalid.
     * Structure: component_name => component_value
     * 
     * @var array Old values array.
     */
    private $old_instance;
    
    /**
     * The new component values array (retrieved from the POST request).
     * Structure: component_name => component_value
     * 
     * @var array New values array.
     */
    private $new_instance;
    
    /**
     * The final values array, after filtering and validation.
     * This is returned by the update function.
     * 
     * @var array Final values array. 
     */
    private $final_instance = array();
    
    /**
     * Array of names of components that were invalid,
     * and the error message recieved.
     * Structure: component_name => error_message
     * 
     * @var string[] Array of error messages. 
     */
    private $errors = array();
    
    /**
     * When instantiating a form, a list of component argument arrays must be provided.
     * Each argument array must have the following arguments, in addition to the
     * component's original arguments:
     * 
     * type (string) - the component's type
     * default (mix) - the component's default value
     * filter (callable) - (optional) the component's value filter callback
     * validation (callable) - (optional) the component's value validation callback
     * 
     * @param array $components An array of arrays of component arguments
     */
    public function __construct( array $components = array() )
    {
        foreach( $components as $args )
        {
            $name = $args['name'];
            if(array_key_exists($name, $components))
            {
                throw new \RuntimeException("A component with the name <b>$name</b> has already been created");
            }
            $this->components[$name] = ComponentFactory::create($args['type'], $args);
        }
    }
    
    /**
     * Get the updated component values (validated, filtered or ignored).
     * 
     * Loops through each component and acts according to its type:
     * - Disableable components are ignored if they are disabled.
     * - Validatable components are validated using their validation function. 
     *   If the new value is invalid, the old value will be used.
     * - Filterable components are filtered using their filter function.
     * - Non-value components are skipped altogether.
     * 
     * Each component is also set with its new value.
     * 
     * @param array $new_instance The new component values array.
     * @param array $old_instance The old component values array.
     * 
     * @return array The updated values array.
     */
    public function update( array $new_instance, array $old_instance = array() )
    {
        $this->old_instance   = array_merge($this->get_defaults(),$old_instance);
        $this->new_instance   = array_merge($this->old_instance,$new_instance);
        $this->final_instance = $this->new_instance;
        
        foreach ( $this->components as $component ) 
        {
            // Update individual fields, as well as the composite parent field.
            if ( $component instanceof ValueComponentInterface )
            {
                $this->update_component( $component );
            }
        }
        
        return $this->final_instance;
    }
    
    /**
     * Reset all fields to their default values.
     * 
     * @param array $names List of component names to be set to their defaults. If no names are specified, all components will be reset
     * @return array The updated values array.
     */
    public function reset( array $names = array() )
    {
        if( array() === $names )
        {
            // Unset new instance to force reset
            $this->new_instance = array();
            return $this->update();
        }
        else
        {
            foreach( $this->components as $c )
            {
                if( in_array($c->name, $names) )
                {
                    $this->new_instance[$c->name] = $c->default;
                }
            }
            return $this->update();
        }
    }
    
    /**
     * Get the list of error messages for components that could not be validated.
     * Structure: components_name => error_message
     * 
     * @return string[] Array of error messages. 
     */
    public function get_errors()
    {
        return $this->errors;
    }
    
    /**
     * Update the component's value with the new value.
     * NOTE: this function also updates the $final_instance
     * array.
     * 
     * @param ValueComponentInterface $component The component to validate.
     */
    private function update_component( ValueComponentInterface $component )
    {
        $component->value = $this->final_instance[$component->name];
        
        // Skip if this field is disabled
        if($component instanceof DisableableComponentInterface &&
           true === $component->disabled) {
            return;
        }
        
        // Apply user-defined filter
        if( $component instanceof FilterableComponentInterface )
        {
            $this->filter( $component );
        }
        
        // Validate value
        if( $component instanceof ValidatableComponentInterface )
        {
            $this->validate( $component );
        }
    }
    
    /**
     * Filter the component's value using its filter function (if applicable)
     * 
     * @param UI\FilterableComponentInterface $component
     */
    private function filter( FilterableComponentInterface $component )
    {
        $filter = $component->filter;
        
        if( is_callable( $filter ) ) 
        {
            $component->value = $filter( $this->final_instance[$component->name] );
            $this->final_instance[$component->name] = $component->value;
        }
    }
    
    /**
     * Validate the component's value using its validation function.
     * 
     * If the value is invalid, the old value is used, and an error message is
     * saved into the errors array as component_name => error_message.
     * 
     * @param ValidatableComponentInterface $component The component to validate.
     */
    private function validate( ValidatableComponentInterface $component )
    {
        $name     = $component->name;
        $validate = $component->validation;
        $valid    = true;
        
        $component->validity = $component::VALID;
        
        if(is_callable($validate))
        {
            $valid = $validate($this->new_instance[$name]);
            
            // Invalid input, use old instance or default value
            if ( true !== $valid ) 
            {
                $this->errors[$name]         = $valid;
                $component->value            = $this->old_instance[$name];
                $component->validity         = $component::INVALID;
                $this->final_instance[$name] = $this->old_instance[$name];
            }
        }
    }
    
    private function get_defaults()
    {
        $defaults = array();
        
        foreach( $this->components as $component )
        {
            $defaults[$component->name] = $component->default;
        }
        
        return $defaults;
    }
}