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
    private $components = array();
    
    /**
     * The old component values array. These values are used if the new values
     * are invalid.
     * Structure: component_name => component_value
     * 
     * @var array Old values array.
     */
    private $old_instance;
    
    /**
     * The new component values array.
     * Structure: component_name => component_value
     * 
     * @var array New values array.
     */
    private $new_instance;
    
    /**
     * The final values array, after filtering and validation.
     * This is returned by the update function.
     * Structure: component_name => component_value
     * 
     * @var array Final values array. 
     */
    private $final_instance = array();
    
    /**
     * Array of names of components that were invalid, and the error message 
     * recieved.
     * Structure: component_name => error_message
     * 
     * @var string[] Array of error messages. 
     */
    private $errors = array();
    
    /**
     * When instantiating a form, a list of component arguments arrays must be 
     * provided. Each arguments array must have a 'type' argument, in addition 
     * to the component's original arguments.
     * 
     * @param array $components An array of arrays of component arguments
     */
    public function __construct( array $components = array() )
    {
        $this->add_components($components);
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
    public function update( array $new_instance = array(), array $old_instance = array() )
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
     * @return array The updated values array.
     */
    public function reset()
    {
        foreach( $this->components as $c )
        {
            $c->value = $c->default;
            $this->final_instance[$c->name] = $c->default;
        }
        return $this->final_instance;
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
     * Add a component to the form.
     * 
     * @param array $args The component arguments
     * @throws \RuntimeException If a component with the same name has already been registered
     */
    public function add_component( array $args )
    {
        $name = $args['name'];
        if(array_key_exists($name, $this->components))
        {
            throw new \RuntimeException("A component with the name <b>$name</b> has already been created");
        }
        $this->components[$name] = ComponentFactory::create($args['type'], $args);
    }
    
    /**
     * Add multiple components to the form.
     * 
     * @param array $components
     */
    public function add_components( array $components )
    {
        foreach( $components as $component )
        {
            $this->add_component($component);
        }
    }
    
    /**
     * Get a component by its name.
     * 
     * @param string $name
     * @return UI\AbstractComponent
     */
    public function get_component( $name )
    {
        return $this->components[$name];
    }
    
    /**
     * Get all components.
     * 
     * @return array
     */
    public function get_components()
    {
        return $this->components;
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
        if( $this->is_disabled($component) )
        {
            return;
        }
        
        // Apply user-defined filter
        $this->filter( $component );
        
        // Validate value
        $this->validate( $component );
    }
    
    /**
     * Check if the given component is disabled.
     * 
     * @param UI\AbstractComponent $component
     * @return boolean
     */
    private function is_disabled( $component )
    {
        return 
            $component instanceof DisableableComponentInterface &&
            (
                true === $component->disabled ||
                true === $component->readonly
            );
    }
    
    /**
     * Filter the component's value using its filter function (if applicable)
     * 
     * @param UI\AbstractComponent $component
     */
    private function filter( $component )
    {
        if( $component instanceof FilterableComponentInterface )
        {
            $filter = $component->filter;

            if( is_callable( $filter ) ) 
            {
                $component->value = \call_user_func_array($filter, array($this->final_instance[$component->name]));
                $this->final_instance[$component->name] = $component->value;
            }
        }
    }
    
    /**
     * Validate the component's value using its validation function.
     * 
     * If the value is invalid, the old value is used, and an error message is
     * saved into the errors array as component_name => error_message.
     * 
     * @param UI\AbstractComponent $component The component to validate.
     */
    private function validate( $component )
    {
        if( !($component instanceof ValidatableComponentInterface) ) return;
        
        $name     = $component->name;
        $validate = $component->validation;
        
        $component->validity = $component::VALID;
        
        if(is_callable($validate))
        {
            $error = '';
            $valid = \call_user_func_array($validate, array($this->final_instance[$name], &$error));
            
            // Invalid input, use old instance or default value
            if ( true !== $valid ) 
            {
                $this->errors[$name]         = $error ? $error : ValidatableComponentInterface::DEFAULT_MESSAGE;
                $component->value            = $this->old_instance[$name];
                $component->validity         = $component::INVALID;
                $this->final_instance[$name] = $this->old_instance[$name];
            }
        }
    }
    
    /**
     * Get the default values for all form components as an array of name => default_value
     * 
     * @return array
     */
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